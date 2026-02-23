<?php
declare(strict_types=1);

namespace App\Core;

final class View
{
    private static string $viewsPath;
    private static string $cachePath;

    public static function init(string $viewsPath, string $cachePath): void
    {
        self::$viewsPath = rtrim($viewsPath, '/');
        self::$cachePath = rtrim($cachePath, '/');
        if (!is_dir(self::$cachePath)) mkdir(self::$cachePath, 0777, true);
    }

    public static function render(string $view, array $data = []): void
    {
        $compiled = self::compile($view);
        extract($data, EXTR_SKIP);
        include $compiled;
    }

    private static function viewFile(string $view): string
    {
        $rel = str_replace('.', '/', $view);
        return self::$viewsPath . '/' . $rel . '.blade.php';
    }

    private static function compiledFile(string $view): string
    {
        $key = md5($view);
        return self::$cachePath . '/blade_' . $key . '.php';
    }

    private static function compile(string $view): string
    {
        $src = self::viewFile($view);
        if (!is_file($src)) {
            throw new \RuntimeException("View not found: $view ($src)");
        }
        $out = self::compiledFile($view);

        if (!is_file($out) || filemtime($out) < filemtime($src)) {
            $code = file_get_contents($src);
            $php = self::compileString($code);
            file_put_contents($out, $php);
        }

        return $out;
    }

    private static function compileString(string $code): string
    {
        // Strip Blade comments
        $code = preg_replace('/\{\{--.*?--\}\}/s', '', $code) ?? $code;

        // Extends/sections/yield (only 'content' used here)
        $extends = null;
        if (preg_match('/@extends\([\'\"]([^\'\"]+)[\'\"]\)/', $code, $m)) {
            $extends = $m[1];
            $code = preg_replace('/@extends\([\'\"][^\'\"]+[\'\"]\)\s*/', '', $code) ?? $code;
        }

        // Sections
        $sections = [];
        $code = preg_replace_callback('/@section\([\'\"]([^\'\"]+)[\'\"]\)(.*?)@endsection/s', function($m) use (&$sections) {
            $sections[$m[1]] = $m[2];
            return '';
        }, $code) ?? $code;

        // Compile common directives in remaining code
        $compiledBody = self::compileDirectives($code);

        if ($extends) {
            $layout = self::compile($extends);

            // precompile section content
            $compiledSections = [];
            foreach ($sections as $name => $content) {
                $compiledSections[$name] = self::compileDirectives($content);
            }

            $php = "<?php\n\$__sections = [];\n";
            foreach ($compiledSections as $name => $contentPhp) {
                $php .= "ob_start(); ?>\n" . $contentPhp . "\n<?php \$__sections['$name'] = ob_get_clean();\n";
            }
            // allow body without section
            if (trim($compiledBody) !== '') {
                $php .= "ob_start(); ?>\n" . $compiledBody . "\n<?php \$__sections['content'] = (\$__sections['content'] ?? '') . ob_get_clean();\n";
            }
            $php .= "include '$layout';\n";
            return $php;
        }

        // Layout file: replace @yield
        $compiledBody = preg_replace_callback('/@yield\([\'\"]([^\'\"]+)[\'\"]\)/', function($m) {
            $name = $m[1];
            return "<?= \$__sections['$name'] ?? '' ?>";
        }, $compiledBody) ?? $compiledBody;

        return "<?php\n?>\n" . $compiledBody;
    }

    private static function compileDirectives(string $code): string
    {
        // CSRF
        $code = str_replace('@csrf', "<input type=\"hidden\" name=\"_token\" value=\"<?= \\App\\Core\\Session::csrfToken() ?>\">", $code);


        // @method('DELETE') support
        $code = preg_replace("/@method\\(\\s*[\x27\x22]([^\x27\x22]+)[\x27\x22]\\s*\\)/", "<input type=\"hidden\" name=\"_method\" value=\"$1\">", $code) ?? $code;

        // @selected(condition) helper
        $code = preg_replace("/@selected\\(\\s*(.*?)\\s*\\)/", "<?= ($1) ? \"selected=\\\"selected\\\"\" : \"\" ?>", $code) ?? $code;
        // Auth directives
        $code = str_replace('@auth', "<?php if(\\App\\Core\\Auth::check()): ?>", $code);
        $code = str_replace('@endauth', "<?php endif; ?>", $code);

        // if/elseif/else/endif
        $code = preg_replace('/@if\s*\((.*?)\)/', '<?php if($1): ?>', $code) ?? $code;
        $code = preg_replace('/@elseif\s*\((.*?)\)/', '<?php elseif($1): ?>', $code) ?? $code;
        $code = str_replace('@else', '<?php else: ?>', $code);
        $code = str_replace('@endif', '<?php endif; ?>', $code);

        // foreach with $loop->index support
        $code = preg_replace_callback('/@foreach\s*\((.*?)\s+as\s+(.*?)\)/', function($m) {
            $iter = trim($m[1]);
            $as = trim($m[2]);
            // If user provided key => value, respect it, else inject $__idx
            if (str_contains($as, '=>')) {
                return "<?php foreach($iter as $as): ?>";
            }
            return "<?php foreach($iter as \$__idx => $as): \$loop = (object)['index'=>\$__idx]; ?>";
        }, $code) ?? $code;
        $code = str_replace('@endforeach', '<?php endforeach; ?>', $code);

        // route()/session() helpers exist

        // Echoes {{ }}
        $code = preg_replace('/\{!!\s*(.*?)\s*!!\}/', '<?= $1 ?>', $code) ?? $code;
        $code = preg_replace('/\{\{\s*(.*?)\s*\}\}/', '<?= htmlspecialchars($1, ENT_QUOTES, "UTF-8") ?>', $code) ?? $code;

        return $code;
    }
}

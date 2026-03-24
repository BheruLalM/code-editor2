<?php

namespace App\Services;

class CodeRunnerService
{
    public function evaluate(string $language, string $code, array $testCases): array
    {
        if ($language !== 'php') {
            return [
                'results' => array_map(fn ($case) => [
                    'input' => $case['input'] ?? '',
                    'expected' => $case['expected'] ?? '',
                    'output' => '',
                    'passed' => false,
                    'error' => 'Only PHP is supported in this MVP.',
                ], $testCases),
            ];
        }

        $results = [];
        foreach ($testCases as $case) {
            $expected = trim((string) ($case['expected'] ?? ''));
            $actual = trim($this->runPhpCode($code, (string) ($case['input'] ?? '')));

            $results[] = [
                'input' => $case['input'] ?? '',
                'expected' => $expected,
                'output' => $actual,
                'passed' => $actual === $expected,
                'error' => null,
            ];
        }

        return ['results' => $results];
    }

    private function runPhpCode(string $code, string $input): string
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'arena_');
        $phpFile = $tmpFile . '.php';

        file_put_contents($phpFile, $code);

        $descriptorSpec = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $process = proc_open("php {$phpFile}", $descriptorSpec, $pipes);
        if (! is_resource($process)) {
            @unlink($phpFile);
            return 'Execution error';
        }

        fwrite($pipes[0], $input);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        proc_close($process);
        @unlink($phpFile);
        @unlink($tmpFile);

        if (! empty($error)) {
            return trim($error);
        }

        return trim((string) $output);
    }
}

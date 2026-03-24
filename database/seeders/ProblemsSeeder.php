<?php

namespace Database\Seeders;

use App\Models\Problem;
use Illuminate\Database\Seeder;

class ProblemsSeeder extends Seeder
{
    public function run(): void
    {
        Problem::updateOrCreate(
            ['title' => 'Sum Two Numbers'],
            [
                'difficulty' => 'easy',
                'description' => 'Read two integers and print their sum.',
                'starter_code' => [
                    'php' => "<?php\n\$line = trim(fgets(STDIN));\n[\$a, \$b] = array_map('intval', explode(' ', \$line));\necho (\$a + \$b);\n",
                ],
                'visible_test_cases' => [
                    ['input' => "2 3\n", 'expected' => '5'],
                    ['input' => "10 20\n", 'expected' => '30'],
                ],
                'hidden_test_cases' => [
                    ['input' => "100 200\n", 'expected' => '300'],
                ],
                'time_limit_seconds' => 2,
                'tags' => ['math', 'basics'],
            ]
        );
    }
}

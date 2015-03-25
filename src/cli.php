<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

$console = new Application('Parallel unit test');
$console
    ->register('test:parallel')
    ->setDefinition(array(
        new InputArgument('home', InputArgument::REQUIRED, 'Home path for unit'),
        new InputArgument('group', InputArgument::OPTIONAL, 'Group test name', 'parallel'),
        new InputArgument('testPath', InputArgument::OPTIONAL, 'Test path', 'unit-parallel'),
    ))
    ->setDescription('Run parallel unit test')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $group = $input->getArgument('group');
        $home = $input->getArgument('home');
        $testsPath = $home . '/' . $input->getArgument('testPath');
        $script = "for f in `cd {$testsPath}; ls *Test.php`\n"
            . "do\n"
            . "echo \"================\n=== Run test ===\n \$f\n================\"\n"
            . "phpunit --bootstrap={$home}/Bootstrap.php --group=before {$testsPath}/\$f\n"
            . "wait\n"
            . "for i in {1..3}\n do\n phpunit --bootstrap={$home}/Bootstrap.php --group={$group} {$testsPath}/\$f&\n done\n"
            . "for i in {1..3}\n do\n wait\n done\n"
            . "fg\n"
            . "done\n"
        ;
        $output->writeln(`$script`);
    })
;
$console->run();

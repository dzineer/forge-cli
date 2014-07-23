<?php namespace Adamgoose\ForgeCli\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class LogCommand extends Command {

  /**
   * Configure the command
   */
  protected function configure()
  {
    $this
      ->setName('log')
      ->setDescription('Get the latest deploy log')
      ->addOption(
        'sh',
        null,
        InputOption::VALUE_NONE,
        'Display the deploy script, as opposed to the output'
      );
  }

  /**
   * @param InputInterface  $input
   * @param OutputInterface $output
   *
   * @return void
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $finder = new Finder();
    $path = '/home/forge/.forge';
    $name = '*.' . ($input->getOption('sh') ? 'sh' : 'output');

    $finder->files()->in($path)->name($name)->sortByName();

    $log = array_pop(iterator_to_array($finder));

    $output->writeln('<info>=== '.$log->getFilename().' ===</info>');
    $output->writeln('<comment>'.$log->getContents().'</comment>');
    $output->writeln('<info>=== End of Log ===</info>');
  }
}
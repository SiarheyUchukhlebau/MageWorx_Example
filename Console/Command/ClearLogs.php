<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace MageWorx\Example\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Area;

class ClearLogs extends Command
{
    const TYPE = 'type';

    const TYPE_OPTION_ALL = 'all';

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * ClearLogs constructor.
     *
     * @param \Magento\Framework\App\State $state
     * @param string|null $name
     * @param string $description
     */
    public function __construct(
        \Magento\Framework\App\State $state,
        string $name = null,
        string $description = 'No description'
    ) {
        parent::__construct($name);
        $this->setDescription($description);
        $this->state = $state;
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->addOption(
            self::TYPE,
            't',
            InputOption::VALUE_OPTIONAL,
            'Type',
            self::TYPE_OPTION_ALL
        );

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->prepare($input, $output);
        $output->writeln('<info>Mode is: ' . $this->state->getMode() . '</info>');
        $output->writeln('<info>Type is: ' . $this->getType() . '</info>');
        $output->writeln('<info>~~~ Ok ~~~</info>');
    }

    /**
     * Save input and output in local params
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    private function prepare(InputInterface $input, OutputInterface $output): void
    {
        $this->input  = $input;
        $this->output = $output;
    }

    /**
     * @return string
     */
    protected function getType(): string
    {
        return $this->input->getOption(self::TYPE) ?? self::TYPE_OPTION_ALL;
    }
}

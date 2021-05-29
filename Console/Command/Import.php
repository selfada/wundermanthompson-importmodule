<?php
declare(strict_types = 1);

/**
 * @Author: Chandan Rai
 * @Creation Date:   2021-05-28 16:02:46
 * @Last Modified by:   Chandan Rai
 * @Last Modified time: 2021-05-28 20:36:25
 * @Email: chandan.rai@adapty.com
 * @Package: WundermanThompson_Import
 * @category: WundermanThompson
 * @copyright: Copyright (c) 2021 Wundermanthompson (http://www.wundermanthompson.com/)
 * @license: http://www.wundermanthompson.com/LICENSE-1.0.html
 */

namespace WundermanThompson\Import\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Import extends Command
{
    const NAME_ARGUMENT = "name";
    const NAME_FILEPATH = "filepath";

    protected $import;

    public function __construct(\WundermanThompson\Import\Helper\CustomerImport $import, string $name = null)
    {
        $this->import = $import;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument(self::NAME_ARGUMENT);
        $path = $input->getArgument(self::NAME_FILEPATH);
        $this
            ->import
            ->execute($name, $path);
        $output->writeln("Customer Import Job Executed. Please verify logs.");
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("wundermanthompson_import");
        $this->setDescription("Import CSV/JSON");
        $this->setDefinition([new InputArgument(self::NAME_ARGUMENT, InputArgument::OPTIONAL, "Name") , new InputArgument(self::NAME_FILEPATH, InputArgument::OPTIONAL, "Filepath") ]);
        parent::configure();
    }
}


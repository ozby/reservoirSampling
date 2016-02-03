<?php
/**
 * Created by PhpStorm.
 * User: ozberk
 * Date: 31/01/16
 * Time: 20:20
 */

namespace RG\Command;


use RG\Model\DataAdapter\AbstractDataAdapter;
use RG\Model\StreamSamplerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractSamplerCommand extends Command
{
    const ARGUMENT_LENGTH = 'length';
    const ARGUMENT_BASE_LENGTH = 'base_length';

    const CONFIG_ENABLED_BASE_LENGTH = 'enabled_base_length';
    const CONFIG_COMMAND_NAME = 'command';
    const CONFIG_COMMAND_DESC = 'command_desc';
    const CONFIG_TITLE = 'title';
    const CONFIG_ADAPTER_NAME = 'adapter_name';


    /**
     * @var StreamSamplerService $sampler
     */
    protected $sampler;

    protected $configuration = null;

    /**
     * @param StreamSamplerService $sampler
     */
    public function __construct(StreamSamplerService $sampler)
    {
        parent::__construct();
        $this->sampler = $sampler;
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName($this->getCommandName())
            ->setDescription($this->getCommandDesc())
            ->addArgument(
                self::ARGUMENT_LENGTH,
                InputArgument::REQUIRED,
                'Length of the base string to be created randomly'
            );

        if ($this->isBaseLengthEnabled()) {
            $this->addArgument(
                self::ARGUMENT_BASE_LENGTH,
                InputArgument::REQUIRED,
                'Size of the random sample'
            );
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getCommandName()
    {
        return $this->getConfiguration(self::CONFIG_COMMAND_NAME);
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getCommandDesc()
    {
        return $this->getConfiguration(self::CONFIG_COMMAND_DESC);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function isBaseLengthEnabled()
    {
        return $this->getConfiguration(self::CONFIG_ENABLED_BASE_LENGTH);

    }

    /**
     * @param string $key
     *
     * @return mixed
     * @throws \Exception
     */
    private function getConfiguration($key)
    {
        if (!isset($this->configuration[$key])) {
            throw new \Exception('configuration error: ' . $key);
        }

        return $this->configuration[$key];
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(ucfirst($this->getCommandName()) . ' Sampler');

        // base length only needed at random and remote.
        $baseLength = null;
        if ($this->isBaseLengthEnabled()) {
            $baseLength = $input->getArgument(self::ARGUMENT_BASE_LENGTH);
        }

        $dataAdapter = AbstractDataAdapter::getAdapterInstance(
            $this->getAdapterName(),
            $baseLength
        );

        $sample = $this->sampler->getRandomSample(
            $dataAdapter,
            $input->getArgument(self::ARGUMENT_LENGTH)
        );

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE
        ) {
            $output->write('Random base: ');
            $dataAdapter->printData($output);
        }

        $output->writeln('Sample: ' . $sample);
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getAdapterName()
    {
        return $this->getConfiguration(self::CONFIG_ADAPTER_NAME);
    }

}
<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\CoreConsole\Commands;

use Piwik\Plugin\Manager;
use Matomo\Dependencies\Symfony\Component\Console\Input\InputInterface;
use Matomo\Dependencies\Symfony\Component\Console\Input\InputOption;
use Matomo\Dependencies\Symfony\Component\Console\Output\OutputInterface;

/**
 */
class GenerateArchiver extends GeneratePluginBase
{
    protected function configure()
    {
        $this->setName('generate:archiver')
            ->setDescription('Adds an Archiver to an existing plugin')
            ->addOption('pluginname', null, InputOption::VALUE_REQUIRED, 'The name of an existing plugin which does not have an Archiver yet');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pluginName = $this->getPluginName($input, $output);
        $this->checkAndUpdateRequiredPiwikVersion($pluginName, $output);

        $exampleFolder  = Manager::getPluginDirectory('ExamplePlugin');
        $replace        = array('ExamplePlugin' => $pluginName, 'EXAMPLEPLUGIN' => strtoupper($pluginName));
        $whitelistFiles = array('/Archiver.php');

        $this->copyTemplateToPlugin($exampleFolder, $pluginName, $replace, $whitelistFiles);

        $this->writeSuccessMessage($output, array(
             sprintf('Archiver.php for %s generated.', $pluginName),
             'You can now start implementing Archiver methods',
             'Enjoy!'
        ));

        return self::SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return array
     * @throws \RuntimeException
     */
    protected function getPluginName(InputInterface $input, OutputInterface $output)
    {
        $pluginNames = $this->getPluginNamesHavingNotSpecificFile('Archiver.php');
        $invalidName = 'You have to enter the name of an existing plugin which does not already have an Archiver';

        return $this->askPluginNameAndValidate($input, $output, $pluginNames, $invalidName);
    }

}

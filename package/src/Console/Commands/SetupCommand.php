<?php

namespace InetStudio\LinksPackage\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:links-package:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup links package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Links setup',
                'command' => 'inetstudio:links-package:links:setup',
            ],
        ];
    }
}

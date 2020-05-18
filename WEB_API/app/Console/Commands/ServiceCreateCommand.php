<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

// 此处需继承「GeneratorCommand」且移除原模板方法才能执行自定生成
class ServiceCreateCommand extends GeneratorCommand
{
    /**
     * name为输入参数
     *
     * @var string
     */
    protected $signature = 'make:service { name }';

    /**
     * 命令说明
     *
     * @var string
     */
    protected $description = 'Create a service';

    /**
     * 定义模板文件位置
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/service.stub';
    }

    /**
     * 默认命名空间
     * @param $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Services';
    }

}

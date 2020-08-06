<?php


namespace App\Components;


/**
 * Class ComponentsContainer
 *
 * @author: TOOM <1023150697@qq.com>
 * @property \App\Components\User $user
 * @property  \App\Components\Security $security
 * @property  \App\Components\wechat\Wechat $wechat
 */
class ComponentsContainer
{
    private $defaultComponents = [
        'user' => [
            'class' => 'App\Components\User'
        ],
        'security' => [
            'class' => 'App\Components\Security'
        ]
    ];

    /**
     * @var mixed
     */
    private $components;


    /**
     * 初始化组件列表
     * ComponentsContainer constructor.
     */
    public function __construct()
    {
        $this->components = config('components', []);
    }

    /**
     * 获取组件
     *
     * @param $name
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function __get($name)
    {
        $component = $this->components[$name] ?? $this->getDefaultComponent($name);
        if (!isset($component['class'])) {
            if (isset($this->getDefaultComponent($name)['class'])) {
                $component['class'] = $this->getDefaultComponent($name)['class'];
            } else {
                echo "EXCEPTION";
                //TODO 抛出异常
            }
        }

        $ref = new \ReflectionClass($component['class']);
        unset($component['class']);
        $instance = $ref->newInstance($component);
        if ($instance instanceof BaseComponents) {
            $this->$name = $instance;
        }
        return $this->$name;
        // TODO: Implement __get() method.
    }

    /**
     * 获取默认组件class
     *
     * @param $name
     *
     * @return string[]|null
     */
    private function getDefaultComponent($name)
    {
        if (isset($this->defaultComponents[$name])) {
            return $this->defaultComponents[$name];
        }
        return null;
    }
}
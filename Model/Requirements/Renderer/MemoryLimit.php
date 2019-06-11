<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  M2E LTD
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Model\Requirements\Renderer;

/**
 * @method \Ess\M2ePro\Model\Requirements\Checks\ExecutionTime getCheckObject()
 */
class MemoryLimit extends AbstractRenderer
{
    //########################################

    public function getTitle()
    {
        return $this->getHelper('Module\Translation')->__('Memory Limit');
    }

    // ---------------------------------------

    public function getMin()
    {
        return <<<HTML
<span style="color: grey;">
      <span>{$this->getCheckObject()->getMin()}</span>&nbsp;/
      <span>{$this->getCheckObject()->getReader()->getMemoryLimitData('recommended')}</span>&nbsp;
      <span>{$this->getCheckObject()->getReader()->getMemoryLimitData('measure')}</span>
</span>
HTML;
    }

    public function getReal()
    {
        $color = $this->getCheckObject()->isMeet() ? 'green' : 'red';
        return <<<HTML
<span style="color: {$color};">
    <span>{$this->getCheckObject()->getReal()}</span>&nbsp;
    <span>{$this->getCheckObject()->getReader()->getMemoryLimitData('measure')}</span>
</span>
HTML;
    }

    //########################################
}
<?php
namespace Majernik\NeuralNetwork\Model;

class Input extends Layer
{
    /**
     * @var float
     */
    protected $value = 0.0;

    public function __construct(float $value = 0.0)
    {
        $this->value = $value;
    }

    public function setValue(float $value)
    {
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getOutput(): float
    {
        return $this->getValue();
    }

    public function getCurrentOutput(): float
    {
        return $this->getOutput();
    }
}

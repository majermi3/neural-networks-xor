<?php
namespace Majernik\NeuralNetwork\Model;

class Output extends Layer
{
    /**
     * @var float
     */
    protected $value = 0.0;

    public function __construct(float $value = 0.0)
    {
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}

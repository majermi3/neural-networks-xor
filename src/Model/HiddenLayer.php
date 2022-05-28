<?php

namespace Majernik\NeuralNetwork\Model;

class HiddenLayer
{
    /**
     * @var Neuron
     */
    protected $neurons;

    public function __construct(array $neurons)
    {
        $this->neurons = $neurons;
    }

    /**
     * @return Neuron[]
     */
    public function getNeurons()
    {
        return $this->neurons;
    }

    public function updateWeigthsAndBiasis(float $error)
    {
        foreach ($this->neurons as $neuron) {
            $neuron->updateWeightsAndBias($error);
        }
    }
}

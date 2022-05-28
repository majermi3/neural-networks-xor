<?php
namespace Majernik\NeuralNetwork\Model;

use Majernik\NeuralNetwork\Utils;
use Majernik\NeuralNetwork\Config;

class Synapse
{
    /**
     * @var Layer
     */
    protected $sourceNeuron;

    /**
     * @var Layer
     */
    protected $targetNeuron;

    protected $weight;

    public function __construct(Layer $sourceNeuron, Layer $targetNeuron)
    {
        $this->sourceNeuron = $sourceNeuron;
        $this->targetNeuron = $targetNeuron;
        $this->weight = Utils::random();
    }

    public function getSourceNeuron(): Layer
    {
        return $this->sourceNeuron;
    }

    public function getTargetNeuron(): Layer
    {
        return $this->targetNeuron;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @var $value The "z"
     * @var $output The "activation"
     */
    public function updateWeight(float $delta)
    {
        //$delta = Utils::derivativeSigmoid($output) * $error;
        //var_dump('weight before: ' . $this->weight);
        $this->weight += $delta * Config::LEARNING_RATE;
        //var_dump('weight: ' . $this->weight);
    }
}

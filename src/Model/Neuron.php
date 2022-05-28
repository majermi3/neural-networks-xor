<?php
namespace Majernik\NeuralNetwork\Model;

use Majernik\NeuralNetwork\Utils;
use Majernik\NeuralNetwork\Config;

class Neuron extends Layer
{
    /**
     * @var float
     */
    protected $value = 0.0;

    /**
     * @var float
     */
    protected $output = 0.0;

    /**
     * @var float
     */
    protected $bias;

    public function __construct()
    {
        $this->bias = Utils::random();
    }

    public function getOutput(): float
    {
        $this->value = $this->bias;
        foreach ($this->getSrouceNeuronOutputs($this) as $output) {
            $this->value += $output;
        }
        $this->output = Utils::normalize($this->value);

        return $this->output;
    }

    public function setOutput(float $output)
    {
        $this->output = $output;
    }

    public function getCurrentOutput(): float
    {
        return $this->output;
    }

    public function updateWeightsAndBias(float $error)
    {
        var_dump($this->id . ' with error: ' . $error);
        //$delta = $error * Utils::derivativeSigmoid($this->output);
        //$this->bias -= $delta * Config::LEARNING_RATE;
        //var_dump('bias after: ' . $this->bias);

        $delta = $error * Utils::derivativeSigmoid($this->getCurrentOutput());
        foreach ($this->getTargetSynapsis($this) as $synapse) {
            // Multiplying the outputDelta with weight of outgoing synapsis
            $parentNeuronOutput = $synapse->getTargetNeuron()->getCurrentOutput();
            $parentNeuronDelta = $error * Utils::derivativeSigmoid($parentNeuronOutput) * $synapse->getWeight();
            $delta *= $parentNeuronDelta;
            $synapse->updateWeight($synapse->getTargetNeuron()->getCurrentOutput() * $parentNeuronDelta);
        }

        $this->bias += $delta * Config::LEARNING_RATE;

        //var_dump('bias: ' . $this->bias);

        foreach ($this->getSrouceSynapsis($this) as $synapse) {
            $synapse->updateWeight($synapse->getSourceNeuron()->getCurrentOutput() * $delta);
            if ($synapse->getSourceNeuron() instanceof Neuron) {
                $synapse->getSourceNeuron()->updateWeightsAndBias($delta);
            }
        }
    }
}

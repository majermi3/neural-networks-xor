<?php
namespace Majernik\NeuralNetwork\Model;

use Majernik\NeuralNetwork\Utils;

class Perceptron
{
    /**
     * @var Input[]
     */
    protected $inputs;

    /**
     * @var HiddenLayer[]
     */
    protected $hiddenLayers;

    /**
     * @var Output
     */
    protected $expectedOutput;

    public function __construct(array $inputs, array $hiddenLayers, Output $expectedOutput)
    {
        $this->inputs = $inputs;
        $this->hiddenLayers = $hiddenLayers;
        $this->expectedOutput = $expectedOutput;
    }

    public function buildSynopsis(): void
    {
        $numOfHiddenLayers = count($this->hiddenLayers);
        $previousHiddenLayer = null;
        foreach ($this->hiddenLayers as $key => $hiddenLayer) {
            if ($previousHiddenLayer === null) {
                foreach ($this->inputs as $input) {
                    $this->addNeurons($input, $hiddenLayer);
                }
            } else {
                foreach ($previousHiddenLayer->getNeurons() as $pos => $neuron) {
                    if ($numOfHiddenLayers - 1 === $key) {
                        // Last layer
                        $neuron->setOutput($this->expectedOutput->getValue());
                    }
                    $this->addNeurons($neuron, $hiddenLayer);
                }
            }
            $previousHiddenLayer = $hiddenLayer;
        }
    }

    private function addNeurons(Layer $layer, HiddenLayer $hiddenLayer)
    {
        foreach ($hiddenLayer->getNeurons() as $neuron) {
            $layer->addSynapse(new Synapse($layer, $neuron));
            $neuron->addSynapse(new Synapse($layer, $neuron));
        }
    }

    public function getOutput(): float
    {
        $sum = 0.0;
        foreach (end($this->hiddenLayers)->getNeurons() as $n => $neuron) {
            $sum += $neuron->getOutput();
        }
        return Utils::normalize($sum);
    }

    public function getError(float $output): float
    {
        return pow($output - $this->expectedOutput->getValue(), 2) / 2;
    }

    public function setInputs(array $inputs): Perceptron
    {
        foreach ($inputs as $pos => $input) {
            $this->inputs[$pos]->setValue($input->getValue());
        }
        return $this;
    }

    public function setExpectedOutput(Output $expectedOutput): Perceptron
    {
        $this->expectedOutput = $expectedOutput;
        return $this;
    }

    public function updateWeigthsAndBiasis(float $output, float $error)
    {
        end($this->hiddenLayers)->updateWeigthsAndBiasis($error);
    }
}

<?php
namespace Majernik\NeuralNetwork;

use Majernik\NeuralNetwork\Model\Input;
use Majernik\NeuralNetwork\Model\Output;
use Majernik\NeuralNetwork\Model\Layer;
use Majernik\NeuralNetwork\Model\Synapse;
use Majernik\NeuralNetwork\Model\Neuron;
use Majernik\NeuralNetwork\Model\HiddenLayer;
use Majernik\NeuralNetwork\Model\Perceptron;
use MathPHP\LinearAlgebra\Matrix;
use MathPHP\LinearAlgebra\MatrixFactory;

class NeuralNetwork
{
    /**
     * @var int
     */
    protected $numberOfNeurons;

    /**
     * @var Perceptron
     */
    protected $perceptron;

    /**
     * @var array
     */
    protected $inputs = [];

    /**
     * @var array
     */
    protected $hiddenLayers = [];

    /**
     * @var Output[]
     */
    protected $expectedOutputs = [];

    /**
     * @var int
     */
    private $idCn = 1;

    public function __construct(
        array $inputs,
        array $hiddenLayers,
        array $expectedOutputs
    ) {
        $this->setInputs($inputs);
        $this->setHiddenLayers($hiddenLayers);
        $this->setExpectedOutputs($expectedOutputs);
    }

    public function build()
    {
        $this->perceptron = new Perceptron(
            current($this->inputs),
            $this->hiddenLayers,
            current($this->expectedOutputs)
        );
        $this->perceptron->buildSynopsis();
    }

    public function train(int $epochs, float $maxError = 0.03)
    {
        echo "Training \n";
        for ($i=0; $i < $epochs; $i++) {
            $errors = [];
            $passed = 0;
            foreach ($this->inputs as $pos => $ipnuts) {
                // Forward propagating
                $output = $this->perceptron
                    ->setInputs($ipnuts)
                    ->setExpectedOutput($this->expectedOutputs[$pos])
                    ->getOutput();
                $error = $this->perceptron->getError($output);

                if ($i % 100 === 0 && $pos < 2) {//
                    var_dump($pos . ' error: '. $error);
                }

                $errors[$pos] = $error;
                if ($error < $maxError) {
                    var_dump($pos . ' passed');
                    $passed++;
                } else {
                    // Backwards propagating
                    $this->perceptron->updateWeigthsAndBiasis($output, $error);
                }
            }
            if ($passed === count($this->expectedOutputs)) {
                // Network is trained
                return;
            }
        }

    }

    public function getOutput(array $inputConfiguration)
    {

    }

    public function setInputs(array $trainingInputConfigurations): void
    {
        foreach ($trainingInputConfigurations as $trainingInputs) {
            $perceptronInputs = [];
            foreach ($trainingInputs as $inputValue) {
                $input = new Input($inputValue);
                $input->setId($this->idCn++);
                $perceptronInputs[] = $input;
            }
            $this->inputs[] = $perceptronInputs;
        }
    }

    public function setHiddenLayers(array $hiddenLayerConfiguration): void
    {
        foreach ($hiddenLayerConfiguration as $numberOfNeurons) {
            $neurons = [];
            for ($i = 0; $i < $numberOfNeurons; $i++) {
                $neuron = new Neuron();
                $neuron->setId($this->idCn++);
                $neurons[] = $neuron;
            }
            $this->hiddenLayers[] = new HiddenLayer($neurons);
        }
    }

    public function setExpectedOutputs(array $expectedOutputConfiguration): void
    {
        foreach ($expectedOutputConfiguration as $expectedOutput)
        {
            $this->expectedOutputs[] = new Output($expectedOutput);
        }
    }
}

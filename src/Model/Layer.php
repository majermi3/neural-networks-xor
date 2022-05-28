<?php

namespace Majernik\NeuralNetwork\Model;

class Layer
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Synapse[]
     */
    protected $synapsis = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function addSynapse(Synapse $synapse)
    {
        $this->synapsis[] = $synapse;
    }

    public function getTargetNeurons(Layer $source): \Generator
    {
        foreach ($this->synapsis as $synapse) {
            if ($synapse->getSourceNeuron() === $source) {
                yield $synapse->getTargetNeuron();
            }
        }
    }

    public function getSrouceNeurons(Layer $target): \Generator
    {
        foreach ($this->synapsis as $synapse) {
            if ($synapse->getTargetNeuron() === $target) {
                yield $synapse->getSourceNeuron();
            }
        }
    }

    public function getSrouceSynapsis(Layer $target): \Generator
    {
        foreach ($this->synapsis as $synapse) {
            if ($synapse->getTargetNeuron() === $target) {
                yield $synapse;
            }
        }
    }

    public function getTargetSynapsis(Layer $source): \Generator
    {
        foreach ($this->synapsis as $synapse) {
            if ($synapse->getSourceNeuron() === $source) {
                yield $synapse;
            }
        }
    }

    public function getSrouceNeuronOutputs(Layer $target): \Generator
    {
        foreach ($this->synapsis as $synapse) {
            if ($synapse->getTargetNeuron() === $target) {
                yield $synapse->getSourceNeuron()->getOutput() * $synapse->getWeight();
            }
        }
    }
}

<?php declare(strict_types=1);

namespace Shopware\Cart\LineItem;

use Shopware\Api\Media\Struct\MediaBasicStruct;
use Shopware\Cart\Price\Struct\Price;
use Shopware\Cart\Rule\Rule;
use Shopware\Cart\Rule\Validatable;
use Shopware\Framework\Struct\Struct;

class CalculatedLineItem extends Struct implements CalculatedLineItemInterface, Validatable
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var Price
     */
    protected $price;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var LineItemInterface|null
     */
    protected $lineItem;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var MediaBasicStruct|null
     */
    protected $cover;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var null|Rule
     */
    protected $rule;

    public function __construct(
        string $identifier,
        Price $price,
        int $quantity,
        string $type,
        string $label,
        string $description = '',
        MediaBasicStruct $cover = null,
        ?LineItemInterface $lineItem = null,
        ?Rule $rule = null
    ) {
        $this->identifier = $identifier;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->type = $type;
        $this->label = $label;
        $this->lineItem = $lineItem;
        $this->description = $description;
        $this->cover = $cover;
        $this->rule = $rule;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getLineItem(): ?LineItemInterface
    {
        return $this->lineItem;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRule(): ?Rule
    {
        return $this->rule;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getCover(): ?MediaBasicStruct
    {
        return $this->cover;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}

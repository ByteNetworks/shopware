<?php
declare(strict_types=1);
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace Shopware\Bundle\CartBundle\Domain\Price;

use Shopware\Bundle\CartBundle\Domain\JsonSerializableTrait;
use Shopware\Bundle\CartBundle\Domain\Tax\CalculatedTaxCollection;
use Shopware\Bundle\CartBundle\Domain\Tax\TaxRuleCollection;

class Price implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @var float
     */
    protected $totalPrice;

    /**
     * @var CalculatedTaxCollection
     */
    protected $calculatedTaxes;

    /**
     * @var TaxRuleCollection
     */
    protected $taxRules;

    /**
     * @var float
     */
    protected $unitPrice;

    /**
     * @var int
     */
    protected $quantity;

    public function __construct(
        float $unitPrice,
        float $totalPrice,
        CalculatedTaxCollection $calculatedTaxes,
        TaxRuleCollection $taxRules,
        int $quantity = 1
    ) {
        $this->unitPrice = $unitPrice;
        $this->totalPrice = $totalPrice;
        $this->calculatedTaxes = $calculatedTaxes;
        $this->taxRules = $taxRules;
        $this->quantity = $quantity;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function getCalculatedTaxes(): CalculatedTaxCollection
    {
        return $this->calculatedTaxes;
    }

    public function getTaxRules(): TaxRuleCollection
    {
        return $this->taxRules;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function add(Price $price): void
    {
        $this->unitPrice += $price->getUnitPrice();
        $this->totalPrice += $price->getTotalPrice();
        $this->calculatedTaxes = $this->calculatedTaxes->merge(
            $price->getCalculatedTaxes()
        );
        $this->taxRules = $this->taxRules->merge(
            $price->getTaxRules()
        );
    }

    public function sub(Price $price): void
    {
        $this->unitPrice -= $price->getUnitPrice();
        $this->totalPrice -= $price->getTotalPrice();
        $this->calculatedTaxes = $this->calculatedTaxes->merge(
            $price->getCalculatedTaxes()
        );
        $this->taxRules = $this->taxRules->merge(
            $price->getTaxRules()
        );
    }
}

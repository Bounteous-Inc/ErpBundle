<?php

namespace DemacMedia\Bundle\ErpBundle\Entity;

use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpCarts;

/**
 * OroErpCartItems
 *
 * @ORM\Table(name="demacmedia_erp_cart_items")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *      defaultValues={
 *          "entity"={
 *              "icon"="icon-ok-circle",
 *              "label"="Erp Cart Items",
 *              "plural_label"="Erp Cart Items",
 *              "description"="Erp Cart Items"
 *          },
 *      "security"={
 *          "type"="ACL"
 *      },
 *      "ownership"={
 *          "owner_type"="USER",
 *          "owner_field_name"="owner",
 *          "owner_column_name"="user_owner_id",
 *          "organization_field_name"="organization",
 *          "organization_column_name"="organization_id"
 *      }
 *  }
 * )
 */
class OroErpCartItems
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="id",
     *              "plural_label"="ids",
     *              "description"="id"
     *          }
     *      }
     * )
     */
    protected $id;


    /**
     * @var integer
     *
     * @ORM\Column(name="cart_item_number", type="integer")
     *
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Cart Item Number",
     *              "plural_label"="Cart Item Numbers",
     *              "description"="Cart Item Numbers"
     *          }
     *      }
     * )
     */
    protected $cartItemNumber;


    /**
     * @var OroErpCarts
     *
     * @ORM\ManyToOne(targetEntity="OroErpCarts", inversedBy="items")
     * @ORM\JoinColumn(name="cart_id", onDelete="CASCADE")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="WebStore Cart",
     *              "plural_label"="WebStore Carts",
     *              "description"="WebStore Cart"
     *          }
     *      }
     * )
     */
    protected $cart;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", length=32, type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Sku",
     *              "plural_label"="Skus",
     *              "description"="Sku"
     *          }
     *      }
     * )
     */
    protected $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Product Name",
     *              "plural_label"="Product Names",
     *              "description"="Product Name"
     *          }
     *      }
     * )
     */
    protected $productName;

    /**
     * @var double
     *
     * @ORM\Column(name="product_price", type="money")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Price",
     *              "plural_label"="Prices",
     *              "description"="Price"
     *          }
     *      }
     * )
     */
    protected $productPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Quantity",
     *              "plural_label"="Quantities",
     *              "description"="Quantity"
     *          }
     *      }
     * )
     */
    protected $quantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Created At",
     *              "plural_label"="Created At",
     *              "description"="Created At"
     *          }
     *      }
     * )
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Updated At",
     *              "plural_label"="Updated At",
     *              "description"="Updated At"
     *          }
     *      }
     * )
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Created At",
     *              "plural_label"="Created At",
     *              "description"="Created At"
     *          }
     *      }
     * )
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Updated At",
     *              "plural_label"="Updated At",
     *              "description"="Updated At"
     *          }
     *      }
     * )
     */
    protected $updated;


    /**
     * @var string
     *
     * @ORM\Column(name="website_id", type="string", length=64)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Website ID",
     *              "plural_label"="Websites ID",
     *              "description"="Website ID"
     *          }
     *      }
     * )
     */
    protected $websiteId;


    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          },
     *          "entity"={
     *              "label"="Owner",
     *              "plural_label"="Owners",
     *              "description"="Owner"
     *          }
     *      }
     * )
     */
    protected $owner;

    /**
     * @var Organization
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          },
     *          "entity"={
     *              "label"="Organization",
     *              "plural_label"="Organizations",
     *              "description"="Organization"
     *          }
     *      }
     * )
     */
    protected $organization;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getOriginalCartItemId()
    {
        return $this->originalCartItemId;
    }

    /**
     * @param int $originalCartItemId
     */
    public function setOriginalCartItemId($originalCartItemId)
    {
        $this->originalCartItemId = $originalCartItemId;
    }

    /**
     * @return \DemacMedia\Bundle\ErpBundle\Entity\OroErpCarts
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @param \DemacMedia\Bundle\ErpBundle\Entity\OroErpCarts $cartId
     */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return float
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * @param float $productPrice
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get created date
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setCreated(\DateTime $date)
    {
        $this->created = $date;

        return $this;
    }

    /**
     * Get updated date
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updated date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setUpdated(\DateTime $date)
    {
        $this->updated = $date;

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     * @return OroErpAccounts
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get organization
     *
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set organization
     *
     * @param Organization $organization
     * @return OroErpAccounts
     */
    public function setOrganization(Organization $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return get_class();
    }

    /**
     * Pre persist event listener
     *
     * @ORM\PrePersist
     */
    public function beforeSave()
    {
        $this->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->updated = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * Pre update event handler
     * @ORM\PreUpdate
     */
    public function doUpdate()
    {
        $this->updated = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * @return int
     */
    public function getCartItemNumber()
    {
        return $this->cartItemNumber;
    }

    /**
     * @param int $cartItemNumber
     */
    public function setCartItemNumber($cartItemNumber)
    {
        $this->cartItemNumber = $cartItemNumber;
    }

    /**
     * @return OroErpCarts
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param OroErpCarts $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return string
     */
    public function getWebsiteId()
    {
        return $this->websiteId;
    }

    /**
     * @param string $websiteId
     */
    public function setWebsiteId($websiteId)
    {
        $this->websiteId = $websiteId;
    }
}

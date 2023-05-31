<?php
namespace LevelShoes\Shopfinder\Api\Data;

/**
 * Shop data interface.
 * @api
 */
interface ShopInterface
{
    const ENTITY_ID = 'shop_id';
    const NAME = 'name';
    const IDENTIFIER = 'identifier';
    const COUNTRY = 'country';
    const IMAGE = 'image';

    /**
     * Get shop ID.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get shop name.
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set shop name.
     *
     * @param string $name
     * @return ShopInterface
     */
    public function setName($name);

    /**
     * Get shop identifier.
     *
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set shop identifier.
     *
     * @param string $identifier
     * @return ShopInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get shop country.
     *
     * @return string|null
     */
    public function getCountry();

    /**
     * Set shop country.
     *
     * @param string $country
     * @return ShopInterface
     */
    public function setCountry($country);

    /**
     * Get shop image.
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Set shop image.
     *
     * @param string $image
     * @return ShopInterface
     */
    public function setImage($image);
}

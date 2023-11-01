<?php

namespace Concrete\Package\PricingSlider\Block\PricingSlider;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Database\Connection\Connection;
use Concrete\Core\Error\ErrorList\ErrorList;

class Controller extends BlockController
{
    protected $btTable = 'btPricingSlider';
    protected $btInterfaceWidth = 400;
    protected $btInterfaceHeight = 500;
    protected $btCacheBlockOutputLifetime = 300;

    public function getBlockTypeDescription()
    {
        return t('Add a pricing slider to your site.');
    }

    public function getBlockTypeName()
    {
        return t("Pricing Slider");
    }

    public function view()
    {
        /** @var Connection $db */
        $db = $this->app->make(Connection::class);
        $items = $db->fetchAll("SELECT * FROM btPricingSliderItems WHERE bID = ?", [$this->bID]);
        $taskNumber = array_column($items, 'taskNumber');
        array_multisort($taskNumber, SORT_ASC, $items);
        $this->set("items", $items);
        $this->set("activeTaskNumber", (int)array_pop(array_reverse($items))["taskNumber"]);
    }

    public function add()
    {
        $this->set("items", []);
        $this->set("selector", "body");
        $this->set("timeout", 7000);
        $this->set("speed", 1500);
        $this->set("targetPage", null);
    }

    public function edit()
    {
        /** @var Connection $db */
        $db = $this->app->make(Connection::class);
        $this->set("items", $db->fetchAll("SELECT * FROM btPricingSliderItems WHERE bID = ?", [$this->bID]));
    }

    public function delete()
    {
        /** @var Connection $db */
        $db = $this->app->make(Connection::class);
        $db->executeQuery("DELETE FROM btPricingSliderItems WHERE bID = ?", [$this->bID]);

        parent::delete();
    }

    public function save($args)
    {
        parent::save($args);

        /** @var Connection $db */
        $db = $this->app->make(Connection::class);
        $db->executeQuery("DELETE FROM btPricingSliderItems WHERE bID = ?", [$this->bID]);

        if (is_array($args["items"])) {
            foreach ($args["items"] as $item) {
                $db->executeQuery("INSERT INTO btPricingSliderItems (bID, taskNumber, price) VALUES (?, ?, ?)", [
                    $this->bID,
                    isset($item["taskNumber"]) && !empty($item["taskNumber"]) ? (int)$item["taskNumber"] : "image",
                    isset($item["price"]) && !empty($item["price"]) ? (float)$item["price"] : null
                ]);
            }
        }
    }

    public function validate($args)
    {
        $e = new ErrorList;

        if (isset($args["items"])) {
            foreach($args["items"] as $item) {
                if (!isset($item["taskNumber"]) || empty($item["taskNumber"]) || !is_numeric($item["taskNumber"])) {
                    $e->addError(t("You need to enter a valid task number."));
                }

                if (!isset($item["price"]) || empty($item["price"]) || !is_numeric($item["price"])) {
                    $e->addError(t("You need to enter a valid price."));
                }
            }
        } else {
            $e->addError(t("You need to add at least one item."));
        }
        
        return $e;
    }

    public function duplicate($newBID)
    {
        parent::duplicate($newBID);

        /** @var Connection $db */
        $db = $this->app->make(Connection::class);

        $copyFields = 'taskNumber, price';
        
        $db->executeUpdate("INSERT INTO btPricingSliderItems (bID, {$copyFields}) SELECT ?, {$copyFields} FROM btPricingSliderItems WHERE bID = ?", [
                $newBID,
                $this->bID
            ]
        );
    }
}
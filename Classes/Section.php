<?php

$subd = "/kidsacademy";
include_once($_SERVER['DOCUMENT_ROOT'] . $subd . "/utilities.php");

class Section {

    private $id;
    private $name;
    private $summary;
    private $menu_order;
    private $icon;
    private $media;

    function getId() {
        return $this->id;
    }

    function setId($v) {
        $this->id = $v;
        return;
    }

    function getName() {
        return $this->name;
    }

    function setName($v) {
        $this->name = $v;
        return;
    }

    function getSummary() {
        return $this->summary;
    }

    function setSummary($v) {
        $this->summary = $v;
        return;
    }

    function getMenuOrder() {
        return $this->menu_order;
    }

    function setMenuOrder($v) {
        $this->menu_order = $v;
        return;
    }

    function getIcon() {
        return $this->icon;
    }

    function setIcon($v) {
        $this->icon = $v;
        return;
    }

    function getMedia() {
        return $this->media;
    }

    function setMedia($v) {
        $this->media = $v;
        return;
    }

    function getSectionById($id) {
        $status = false;
        if (cb_connect()) {
            $query = "SELECT * FROM sections WHERE id = " . $id . " LIMIT 0,1";
            $result = mysql_query($query);
            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_assoc($result);
                $this->setId($row["id"]);
                $this->setName($row["name"]);
                $this->setSummary($row["summary"]);
                $this->setMenuOrder($row["menu_order"]);
                $this->setIcon($row["icon"]);
                $this->setMedia($row["media"]);
                $status = true;
            }
        } else {
            error_log("DB Not Connected in UserGroup.php SELECT");
        }
        return $status;
    }

    function save() {
        $status = false;
        if (cb_connect()) {
            if ($this->getId() == "new") {
                $query = "INSERT INTO sections (name, summary, menu_order, icon, media)";
                $query.= " VALUES ('" . $this->getName() . "', " . $this->getSummary() . "'";
                $query.= ", " . $this->getMenuOrder() . ", '" . $this->getIcon() . "'";
                $query.= ", '" . $this->getMedia() . "')";
                $result = mysql_query($query);
                $new_id = mysql_insert_id();
                if ($new_id != null) {
                    $this->setId($new_id);
                    $status = true;
                }
            } else {
                $query = "UPDATE sections SET name = '" . $this->getName() . "'";
                $query.= ", summary = '" . $this->getSummary() . "'";
                $query.= ", menu_order = " . $this->getMenuOrder();
                $query.= ", icon = '" . $this->getIcon() . "'";
                $query.= ", media = '" . $this->getMedia() . "'";
                $query.= "  WHERE id = " . $this->getId();
                $result = mysql_query($query);
                $status = true;
            }
        } else {
            error_log("DB Not Connected in UserGroup.php");
        }
        return $status;
    }

    // Deletes the object in memory from the database.

    function delete() {
        $status = false;
        if (cb_connect()) {
            $result = mysql_query("DELETE FROM sections WHERE id = " . $this->getId());
            $status = true;
        }
        return $status;
    }

    function listSections() {
        $result = false;
        if (cb_connect()) {
            $result = mysql_query("SELECT * FROM sections");
        }
        return $result;
    }
}
?>
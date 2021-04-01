<?php
namespace App\Models;

class ArticlesModel extends Model {

  protected $id;
  protected $titre;
  protected $description;
  protected $actif;
  protected $created_at;
  protected $image;
  protected $categorie_id;

  public function __construct() {
      $this->table = 'articles';
      $this->getConnexion();
  }

  /**
   * Get the value of titre
   */ 
  public function getTitre()
  {
    return $this->titre;
  }

  /**
   * Set the value of titre
   *
   * @return  self
   */ 
  public function setTitre($titre)
  {
    $this->titre = $titre;

    return $this;
  }

  /**
   * Get the value of description
   */ 
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @return  self
   */ 
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of actif
   */ 
  public function getActif()
  {
    return $this->actif;
  }

  /**
   * Set the value of actif
   *
   * @return  self
   */ 
  public function setActif($actif)
  {
    $this->actif = $actif;

    return $this;
  }

  /**
   * Get the value of created_at
   */ 
  public function getCreated_at()
  {
    return $this->created_at;
  }

  /**
   * Set the value of created_at
   *
   * @return  self
   */ 
  public function setCreated_at($created_at)
  {
    $this->created_at = $created_at;

    return $this;
  }

  /**
   * Get the value of image
   */ 
  public function getImage()
  {
    return $this->image;
  }

  /**
   * Set the value of image
   *
   * @return  self
   */ 
  public function setImage($image)
  {
    $this->image = $image;

    return $this;
  }

  /**
   * Get the value of id
   */ 
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */ 
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of categorie_id
   */ 
  public function getCategorie_id()
  {
    return $this->categorie_id;
  }

  /**
   * Set the value of categorie_id
   *
   * @return  self
   */ 
  public function setCategorie_id($categorie_id)
  {
    $this->categorie_id = $categorie_id;

    return $this;
  }
}
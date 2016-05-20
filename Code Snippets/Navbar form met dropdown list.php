<form action="aanbiedMenu.php" method="POST">
<nav class = "navbar navbar-inverse">
  <div class = "container">
    <ul class = "nav navbar-nav">
      <li><label style="padding: 5px; margin: 5px;" for="selectCategorie"><b class="white">Categorie:</b></label></li>
      <li><select style="padding: 5px; margin: 5px;" class="form-control" id="selectCategorie" name="categorie">
        <?php
          foreach ($list_categories as $row)
          {
                echo"<option>";
                echo ($row);
                echo "</option>";
          } 
        ?>
      </select></li>

      <li><input style="margin: 10px;" type="submit" name="submit" value="Zoeken"></li>
    </ul>
  </div>
</nav>
</form>
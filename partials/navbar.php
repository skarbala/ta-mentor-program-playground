<?php
$navigation = [
    "savings calculator",
    "spelleology",
];
$current_page = basename($_SERVER['REQUEST_URI'], ".php");

function makeLink($link)
{
    return strtolower(str_replace(" ", "", $link));
}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
        <?php foreach ($navigation as $navigationItem) {
            echo "<li class='nav-item'";
            if (makeLink($navigationItem) == $current_page) {
                echo "class='active'";
            }
            echo ">";
            echo "<a class='nav-link' href =" . makeLink($navigationItem) . ".php>";
            echo ucfirst($navigationItem);
            echo "</a>";
            echo "</li>";
        }
        ?>
    </ul>
  </div>
</nav>
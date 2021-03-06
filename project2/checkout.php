<!DOCTYPE html>
<!--
    CS 137
    Project 2
    Group 1

    checkout.php
-->
<?php
require_once "pdo.php";
?>
<html>
    <head>
        <title>JavaSipt - Checkout</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="styles.css"/>
        <link rel="SHORTCUT ICON" href="images/favicon.ico"/>
        <link rel="icon" href="images/favicon.ico" type="image/ico"/>
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
        <script src="scripts.js"></script>
    </head>
    <body>
        <div id="nav" class="nav_rel">
            <ul>
                <li><a href="index.html">Home</a></li><!-- display inline block :(
             --><li><a href="products.php">Products</a></li>
            </ul>
        </div>
        <div id="firstcontent" class="checkout">
            <?php
            require_once "pdo.php";
            $i = isset($_GET['i']) ? $_GET['i'] : "0";
            $stmt = $pdo->query("SELECT * FROM product WHERE product_id = $i");
            $row = $stmt->fetch();
            ?>
            <div id="item_info">
                <h2 id="co_item_name" class="co_item_text"><?php echo $row['name']; ?></h2>
                <h3 id="co_item_price" class="co_item_text">$<?php echo $row['price']; ?></h3>
                <img id="co_item_img" src=<?php echo '"'; echo $row['image_src']; echo '"'; ?> alt="You shouldn't be here, mate.">
                <p id="co_item_desc" class="co_item_text"><?php echo $row['description']; ?></p>
            </div>
            <form name="checkout_form" id="checkout_form" method="get" action="">
                <div class="form_container">
                    <h3>Product:</h3>
                    <select name="product" size="1" onchange="load_changed(this.value);" tabindex="1">
                        <?php
                        $stmt = $pdo->query("SELECT * FROM product");
                        $type="";
                        foreach($stmt as $row) {
                            if ($row['type'] != $type) {
                                if ($type != "") {
                                    echo "</optgroup>";
                                }
                                echo "<optgroup label=\"";
                                echo ucfirst($row['type']);
                                echo "\">";
                                $type=$row['type'];
                            }
                            echo "<option value=\"";
                            echo $row['product_id'];
                            echo "\">";
                            echo $row['name'];
                            echo "</option>";
                        }
                        echo "</optgroup>";
                        ?>
			<script>set_checkout();</script>
                        
                    </select>
                </div>
                <div class="form_container">
                    <h3>Quantity:</h3>
                    <select name="quantity" size="1" tabindex="2">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
                <div class="form_container">
                    <h3>Shipping Information:</h3>
                    <div class="form_left">
                        <p>First Name:</p>
                        <input type="text" name="fname" tabindex="3" required>
                    </div>
                    <div class="form_right">
                        <p>Last Name:</p>
                        <input type="text" name="lname" tabindex="4" required>
                    </div>
                </div>
                <div class="form_container">
                    <div class="form_left">
                        <p>Address:</p>
                        <input type="text" name="addr_s" tabindex="5" required>
                        <p>State:</p>
                        <input type="text" name="state_s" id="state_s" size="2" maxlength="2" tabindex="7" required>
                        <p>Phone Number:</p>
                        <input type="text" name="pnumber_s" size="10" maxlength="10" tabindex="9" required>
                    </div>
                    <div class="form_right">
                        <p>City:</p>
                        <input type="text" name="city_s" id="city_s" tabindex="6" required>
                        <p>Zip Code:</p>
                        <input type="text" name="zip_s" id="zip_s" size="5" maxlength="5" tabindex="8" required onblur="getPlace(this.value)">
                    </div>
                </div>
                <div class="form_container">
                    <h3>Billing Information:</h3>
                    <input type="checkbox" name="sameship" onchange="set_shipping();" tabindex="10">Check if billing address is same as above.<br>
                    <div class="form_left">
                        <p>Address:</p>
                        <input type="text" name="addr" tabindex="11" required>
                        <p>State:</p>
                        <input type="text" name="state" id="state" size="2" maxlength="2" tabindex="13" required>
                        <p>Phone Number:</p>
                        <input type="text" name="pnumber" size="10" maxlength="10" tabindex="15" required>
                    </div>
                    <div class="form_right">
                        <p>City:</p>
                        <input type="text" name="city" id="city" tabindex="12" required>
                        <p>Zip Code:</p>
                        <input type="text" name="zip" id="zip" size="5" maxlength="5" tabindex="14" required onblur="getPlaceB(this.value)">
                    </div>
                </div>
                <div class="form_container">
                    <p>Payment Method:</p>
                    <input type="radio" name="payment" value="visa" id="def_payment" tabindex="16" checked>Visa<br>
                    <input type="radio" name="payment" value="master">MasterCard<br>
                    <input type="radio" name="payment" value="discover">Discover<br>
                    <input type="radio" name="payment" value="amex">American Express
                </div>
                <div class="form_container">
                    <h3>Card Information:</h3>
                    <p>Card Number:</p>
                    <input type="text" name="cardnumber" maxlength="16" tabindex="17" required><br>
                    <p>Name on Card:</p>
                    <input type="text" name="nameoncard" tabindex="18" required><br>
                    <p>Expiration Date:</p>
                    <select name="month" size="1" tabindex="19" required>
                        <option value="0">Month</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select name="year" size="1" tabindex="20" required>
                        <option value="0">Year</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                    <p>Security Code:</p>
                    <input type="text" name="securitycode" size="3" maxlength="3" tabindex="21" required>
                </div>
                <div class="form_container">
                    <p>Shipping Method:</p>
                    <select id="ships" name="shipping_method" size="1" tabindex="22" required>
                        <option value="3">6-Days Ground - $3</option>
                        <option value="6">2-Days Expedited - $6</option>
                        <option value="10">Overnight - $10</option>
                    </select>
                </div>
                <div class="form_container">
                    <input type="button" value="Reset" tabindex="23" onclick="form_reset();">
                    <input type="button" value="Submit" tabindex="24" onclick="return form_validate();">
                </div>
            </form>
        </div>
    </body>
</html>

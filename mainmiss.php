<?php
require_once './connection.php';
?>


<!-- Check Pincode -->

<?php
if(@$_REQUEST['pincode']!="" && @$_REQUEST['storeid']!="")
{
  $pincode = mysqli_query($con,"select * from delivery_pincode where assignid=$_REQUEST[storeid] and delivery_pincode=$_REQUEST[pincode]");
  $pincode1 = mysqli_fetch_array($pincode);
  if($pincode1)
  {
    echo "<font class='w3-text-green'>Yes, delivery available</font>";
  }
  else
  {
    echo "<font class='w3-text-red'>Sorry! No delivery found</font>";
  }
}

?>

<!-- Cart -->
<?php
if(@$_REQUEST['tab'] == "cart")
{
  if(@$_REQUEST['cartid']!="" && @$_REQUEST['cqty']!=0 && @$_REQUEST['purpose']!="display")
  {
    if($_REQUEST['purpose']=="add")
    {
      $cqty = @$_REQUEST['cqty']+1;
    }
    if($_REQUEST['purpose']=="minus")
    {
      $cqty = @$_REQUEST['cqty']-1; 
    }
    if($_REQUEST['purpose']=="change")
    {
      $cqty = @$_REQUEST['cqty']; 
      if($cqty>5)
      {
        echo "<script>alert('Sorry quantity must be between 1 and 5');</script>";
        $cqty = 5;
      }
    }
    if($cqty>=6 || $cqty<=0)
    {
      echo "<script>alert('Sorry quantity must be between 1 and 5');</script>";
    }
    else
    {
      $productid = $_REQUEST['cartid'];
      $userid = $_SESSION['user'];
      $selc = mysqli_query($con,"select * from cart c,productmaster p where c.productid=$productid and c.userid='$userid' and c.productid=p.productid and c.comes_from=0");
      $selc1=mysqli_fetch_array($selc);

      $productQty = $selc1['qty'];
      if($productQty<$cqty)
      {
        echo "<script>alert('Sorry Only $productQty Quantity Found');</script>";
        $cqty = $productQty;
      }

      $totalprice = $selc1['price']*$cqty;

      $session = $userid.$productid;

      if(@$_SESSION["$session"]=="")
      {
        $_SESSION["$session"] = $selc1['discount'];
      }
      $discount = $_SESSION["$session"];
      $totaldiscount = $discount*$cqty;
      
      $grandtotal = $totalprice-$totaldiscount;
      $upqty = mysqli_query($con,"update cart set cart_qty=$cqty,totalprice=$totalprice,discount=$totaldiscount,grandtotal=$grandtotal where productid=$productid and userid='$userid' and comes_from=0");
    }
    
  }

  if(@$_REQUEST['cartid']!="" && $_REQUEST['cqty']==0 && @$_REQUEST['purpose']=="display")
  {
    $del = mysqli_query($con,"delete from cart where cartid=$_REQUEST[cartid] and comes_from=0");
  }
  $count = mysqli_query($con,"select count(*) from cart where userid='$_SESSION[user]' and comes_from=0");
  $count1 = mysqli_fetch_array($count);
?>
<div class="w3-row-padding" style="border:1px solid #eee;margin-top: 5px;width: 90%;">
  <div class="w3-row w3-panel" >
    <b class="w3-large">My Cart (<?php echo $count1[0]; ?>)</b>
  </div>
</div>
  <?php
  $c=0;
  $gTotal=0;
  $cart = mysqli_query($con, "select * from productmaster p,cart c,petasubcategory ps,measure m,servicesassign sa where c.userid='$_SESSION[user]' and c.productid=p.productid and p.petasubcatid=ps.petasubcatid and p.measureid=m.measureid and p.assignid=sa.assignid and c.comes_from=0");
  while($cart1=mysqli_fetch_array($cart))
  {
    $c++;
    $gTotal = $gTotal+$cart1['grandtotal'];
    $rate = mysqli_query($con,"select sum(rate) from rateproduct where productid=$cart1[productid]");
    $rate1 = mysqli_fetch_array($rate);
    $user = mysqli_query($con,"select count(*) from rateproduct where productid=$cart1[productid]");
    $totalRate = 0;
    $user1 = mysqli_fetch_array($user);
    if($user1[0] > 0)
    {
      $totalRate = ceil($rate1[0]/$user1[0]);
    }
  ?>
    <div class="w3-row w3-padding-16" style="border:1px solid #eee;width: 90%;">
    <div class="w3-col l2">
      <a href="productinfo.php?proid=<?php echo $cart1['productid']; ?>"><img src="<?php echo $cart1['imagepath']?>" style="height:120px;width:120px;"/></a>
        <div class="w3-row-padding">
          <i class="fa fa-minus-circle" onclick="cart('cart',<?php echo $cart1['productid'] ?>,'minus',document.getElementById('<?php echo $c; ?>').value);" style="font-size: 18px;color:#878787"></i>&nbsp;&nbsp;
          <input type="text" style="border:1px solid #878787;width:38%;text-align: center;" min="1" max="5" value="<?php echo $cart1['cart_qty'] ?>" id="<?php echo $c; ?>" onblur="cart('cart',<?php echo $cart1['productid'] ?>,'change',this.value);" />&nbsp;&nbsp;
          <i class="fa fa-plus-circle" style="font-size: 18px;color:#878787;z-index:999;margin-right: 5px;" onclick="cart('cart',<?php echo $cart1['productid'] ?>,'add',document.getElementById('<?php echo $c; ?>').value);" ></i>
        </div>
      
    </div>

    <div class="w3-rest">
      <div class="w3-right" style="margin-right: 10px;">
            <i style="font-size: 17px;" onclick="if(confirm('Are you sure want to delete item from cart?')){cart('cart',<?php echo $cart1['cartid']; ?>,'display',0)}" class="fa fa-trash"></i>
      </div>
      <div style="margin-top: 10px;text-transform: capitalize;font-size: 15px;">
        <a style="color:#000;" href="productinfo.php?proid=<?php echo $cart1['cartid']; ?>"><?php echo $cart1['petasubcatname']; ?></a><br/>
        <div style="background: #4E75F3;width:40px;padding: 3px 3px 3px 6px;margin-top: 5px;border-radius: 5px;color:#fff;"><?php echo $totalRate; ?>&nbsp;<i class="fa fa-star" style="font-size: 12px;"></i> </div>
          <div style="padding-top: 5px;font-size: 17px;"><b>&#8377; <?php echo $cart1['totalprice']; ?>
            <?php echo "(".$cart1['cart_qty']." ".$cart1['measure'].")"; ?></b><br/>
            <font style="font-size: 13px;font-weight: bold;">Discount :  &#8377;&nbsp;<?php echo $cart1['discount']; ?>&nbsp; |  Total Price : &#8377;&nbsp;<?php echo $cart1['grandtotal']; ?></font>
          </b></div>
          <font style="font-weight: bold;font-size:13px;">Seller : </font><font style="font-weight: bold;font-size:13px;color:#4E75F3;"><?php echo $cart1['businessname']; ?></font>
          <?php 
          if($cart1['qty']==0)
          {
            echo "<font class='w3-text-red w3-right' style='font-size:13px;margin-right:20px;'>Sorry! No Quantity Found...</font>";
          }
          if($cart1['qty']==1)
          {
            echo "<font class='w3-text-red w3-right' style='font-size:13px;margin-right:20px;'>Only 1 Product Found. Hurry Up!</font>";
          }
          ?>
          
      </div>
    </div>
   </div>
  <?php
  }
  if($c==0)
  {
  ?>
  <div class="w3-row" style="border:1px solid #eee;padding: 30px 0px 30px 20px;width: 90%;font-size: 18px;">
    <b>Your Shopping Cart is empty</b> <a href="product.php" class="w3-button" style="background: #F0D112;">Click Here To Shopping</a>
  </div>
  <?php
  }
  if($c!=0)
  {
  ?>
  <div class="w3-row" style="border:1px solid #eee;padding: 15px 0px 15px 20px;width: 90%;font-size: 18px;">
    <div class="w3-half">
      <div class="w3-row" style="padding-top: 0px;font-size: 14px;">
        <font>Price (<?php echo $count1[0]; ?> items)&nbsp;&nbsp;&#8377;&nbsp;<?php echo $gTotal; ?></font><br/>
        <font>Delivery Charges :  
          <?php
          if($gTotal>=500)
          {
            echo "No Delivery Charge";
          }
          else
          {
            echo "&#8377;&nbsp;30";
          }
          ?>

        </font>
      </div>
      
    </div>
    <form method="post">
    <div class="w3-half">
        <a href="product.php" class="w3-button" style="width:50%;border:1px solid #eee;padding: 10px;color:#515151;font-size: 18px;text-transform: uppercase;"><b>< continue shopping</b></a>
        <button type="submit" name="place_order" href="product.php" class="w3-button" style="width:45%;background:#FB641B;border:1px solid #eee;padding: 10px;color:#fff;font-size: 18px;text-transform: uppercase;">place order</button>
    </div>
  </form>
  </div>

  <?php
  }
}
?>



<!-- Wishlist -->

<?php
if(@$_REQUEST['tab'] == "wishlist")
{
  if(@$_REQUEST['wishid']!="")
  {
    $del = mysqli_query($con,"delete from wishlist where wishid=$_REQUEST[wishid]");
  }
  $count = mysqli_query($con,"select count(*) from wishlist where userid='$_SESSION[user]'");
  $count1 = mysqli_fetch_array($count);
 ?>
<div class="w3-row-padding" style="border:1px solid #eee;margin-top: 5px;width: 90%;">
  <div class="w3-row w3-panel" >
    <b class="w3-large">My Wishlist (<?php echo $count1[0]; ?>)</b>
  </div>
</div>
  <?php
  $wish = mysqli_query($con, "select * from wishlist w,productmaster p,petasubcategory ps where w.userid='$_SESSION[user]' and w.productid=p.productid and p.petasubcatid=ps.petasubcatid");
  while($wish1 = mysqli_fetch_array($wish))
  {
    $rate = mysqli_query($con,"select sum(rate) from rateproduct where productid=$wish1[productid]");
    $rate1 = mysqli_fetch_array($rate);
    $user = mysqli_query($con,"select count(*) from rateproduct where productid=$wish1[productid]");
    $totalRate = 0;
    $user1 = mysqli_fetch_array($user);
    if($user1[0] > 0)
    {
      $totalRate = ceil($rate1[0]/$user1[0]);
    }
   ?>
   <div class="w3-row w3-padding-16" style="border:1px solid #eee;width: 90%;">
    <div class="w3-col l2">
      <a href="productinfo.php?proid=<?php echo $wish1['productid']; ?>"><img src="<?php echo $wish1['imagepath']?>" style="height:120px;width:120px;"/></a>
    </div>
    <div class="w3-rest">
      <div class="w3-right" style="margin-right: 10px;">
            <i style="font-size: 17px;" onclick="if(confirm('Are you sure want to delete?')){wishlist('wishlist',<?php echo $wish1['wishid']; ?>)}" class="fa fa-trash"></i>
      </div>
      <div style="margin-top: 10px;text-transform: capitalize;font-size: 15px;">
        <a style="color:#000;" href="productinfo.php?proid=<?php echo $wish1['productid']; ?>"><?php echo $wish1['petasubcatname']; ?></a><br/>
        <div style="background: #4E75F3;width:40px;padding: 3px 3px 3px 6px;margin-top: 5px;border-radius: 5px;color:#fff;"><?php echo $totalRate; ?>&nbsp;<i class="fa fa-star" style="font-size: 12px;"></i> </div>
          <div style="padding-top: 5px;font-size: 17px;"><b>&#8377; <?php echo $wish1['price']; ?></b></div>

          <?php 
          if($wish1['qty']==0)
          {
            echo "<font class='w3-text-red' style='font-size:13px;'>Sorry! No Quantity Found...</font>";
          }
          if($wish1['qty']==1)
          {
            echo "<font class='w3-text-red' style='font-size:13px;'>Only 1 Product Found. Hurry Up!</font>";
          }
          ?>
          
      </div>
    </div>
   </div>

   <?php 
  }
}

?>


<!--City-->

<?php
if(@$_REQUEST['tab']=="pincode")
{
     if($_REQUEST['work']=="display")
     {
     ?>
        <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('pincode',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input"  style="width: 84%;float: right" type="text" name="pincodesearch" autofocus="" onkeyup="display('pincode',1,document.getElementById('nrec').value)" placeholder="Search Pincode" id="ss"/>
            </div>   
      </div>

       <div class="w3-row w3-padding-24">
          <div class="w3-half" id="pincode" >

          </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
        <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="recyclebin('rpincode',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input type="text" class="w3-input" style="width: 84%;float: right" name="pincodesearch" autofocus="" onkeyup="recyclebin('rpincode',1,document.getElementById('nrec').value)" placeholder="Search Pincode"  id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
              <div class="w3-half" id="rpincode" >

              </div>
         </div>
      <?php
     }
}
 ?>

 <?php 
if(@$_REQUEST['tab']=="size")
{
     if($_REQUEST['work']=="display")
     {
     ?>
        <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('size',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input"  style="width: 84%;float: right" type="text" name="sizesearch" autofocus="" onkeyup="display('size',1,document.getElementById('nrec').value)" placeholder="Search size" id="ss"/>
            </div>   
      </div>

       <div class="w3-row w3-padding-24">
          <div class="w3-half" id="size" >

          </div>
       </div>
      <?php
     }
   }?>
<!--City-->

<?php
if(@$_REQUEST['tab']=="city")
{
     if($_REQUEST['work']=="display")
     {
     ?>
        <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('city',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input"  style="width: 84%;float: right" type="text" name="citysearch" autofocus="" onkeyup="display('city',1,document.getElementById('nrec').value)" placeholder="Search city" id="ss"/>
            </div>   
      </div>

       <div class="w3-row w3-padding-24">
          <div class="w3-half" id="city" >

          </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
        <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="recyclebin('rcity',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input type="text" class="w3-input" style="width: 84%;float: right" name="citysearch" autofocus="" onkeyup="recyclebin('rcity',1,document.getElementById('nrec').value)" placeholder="Search city"  id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
              <div class="w3-half" id="rcity" >

              </div>
         </div>
      <?php
     }
}
 ?>

<!--Area-->      
      
<?php
if(@$_REQUEST['tab']=="area")
{
     if($_REQUEST['work']=="display")
     {
     ?>
    <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="display('area',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <input type="text" class="w3-input"  style="width: 84%;float: right" name="areasearch" autofocus="" onkeyup="display('area',1,document.getElementById('nrec').value)" placeholder="Search Area" class="form-control" id="ss"/>
        </div>
    </div>
    <div class="w3-row w3-padding-24">
        <div id="area" class="w3-half">

        </div>
    </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
     <div class="w3-row">
         <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="recyclebin('rarea',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <input type="text" name="citysearch" style="width: 84%;float: right" autofocus="" onkeyup="recyclebin('rarea',1,document.getElementById('nrec').value)" placeholder="Search city" class="w3-input" id="ss"/>
        </div>
    </div>

     <div class="w3-row w3-padding-24">
        <div id="rarea" class="w3-half">

        </div>
     </div>
      <?php
     }
}
 ?>

<!--Feedback-->      
      
<?php
if(@$_REQUEST['tab']=="feedback")
{
     if($_REQUEST['work']=="display")
     {
     ?>
      <div class="w3-row">
            <div class="w3-row" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('feedback',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input"  style="width: 84%;float: right" type="text" name="feedbacksearch" autofocus="" onkeyup="display('feedback',1,document.getElementById('nrec').value)" placeholder="Search Feedback" class="form-control" id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
            <div class="w3-row" id="feedback" >

            </div>
       </div>
      <?php
     }
   
}
 ?>

<!--Contact-->      
      
<?php
if(@$_REQUEST['tab']=="contact")
{
     if($_REQUEST['work']=="display")
     {
     ?>
      <div class="w3-row">
            <div class="w3-row" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('contact',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                 <input class="w3-input"  style="width: 84%;float: right" type="text" name="contactsearch" autofocus="" onkeyup="display('contact',1,document.getElementById('nrec').value)" placeholder="Search Contact" class="form-control" id="ss"/>
            </div>
        </div>
        
        <div class="w3-row w3-padding-24">
            <div class="w3-row" id="contact" >

            </div>
       </div>
      <?php
     }
   
}
 ?>

<!--User-->  
      
<?php
if(@$_REQUEST['tab']=="user")
{
     if($_REQUEST['work']=="display")
     {
     ?>
        <div class="w3-row">
            <div class="w3-row" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('user',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input"  style="width: 84%;float: right" type="text" name="usersearch" autofocus="" onkeyup="display('user',1,document.getElementById('nrec').value)" placeholder="Search Customer" class="form-control" id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
            <div class="w3-row" id="user" >

            </div>
       </div>
      <?php
     }
}
 ?>

      
      
<!-- Service Provider Review-->  
      
<?php
if(@$_REQUEST['tab']=="review")
{
    if($_REQUEST['work']=="load")
    {
     ?>
    <p class="cityhead">Load</p>
    <?php
    }

     if($_REQUEST['work']=="display")
     {
     ?>
      <p class="cityhead">Display Service Provider Review</p>
       <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="input-group">
                            <div class="input-group-addon selcity">
                                <select class="input-control" onchange="display('review',1,this.value)" id="nrec" >

                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
          <input type="text" name="usersearch" autofocus="" onkeyup="display('review',1,document.getElementById('nrec').value)" placeholder="Search User" class="form-control" id="ss"/>
                                <div class="input-group-addon">
                                    <font><i class="fa fa-search"></i></font>
                                </div>
                        </div>

           <div id="review" style="margin-top: 5%;" >

           </div>

       </div>
      <?php
     }
}
 ?>
      
      
<!-- Producr Review-->      
       
      
<?php
if(@$_REQUEST['tab']=="productreview")
{
    if($_REQUEST['work']=="load")
    {
     ?>
    <p class="cityhead">Load</p>
    <?php
    }

     if($_REQUEST['work']=="display")
     {
     ?>
      <p class="cityhead">Display Product Review</p>
       <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="input-group">
                            <div class="input-group-addon selcity">
                                <select class="input-control" onchange="display('productreview',1,this.value)" id="nrec" >

                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
          <input type="text" name="usersearch" autofocus="" onkeyup="display('productreview',1,document.getElementById('nrec').value)" placeholder="Search Review" class="form-control" id="ss"/>
                                <div class="input-group-addon">
                                    <font><i class="fa fa-search"></i></font>
                                </div>
                        </div>

           <div id="productreview" style="margin-top: 5%;" >

           </div>

       </div>
      <?php
     }
}
 ?>


<!-- Manage Inquiry Info Service Provider -->      
       
      
<?php
if(@$_REQUEST['tab']=="inquiry")
{
    if($_REQUEST['work']=="load")
    {
     ?>
    <p class="cityhead">Load</p>
    <?php
    }

     if($_REQUEST['work']=="display")
     {
     ?>
      <p class="cityhead">Display Inquiry Messsage</p>
       <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="input-group">
                            <div class="input-group-addon selcity">
                                <select class="input-control" onchange="display('inquiry',1,this.value)" id="nrec" >

                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
          <input type="text" name="usersearch" autofocus="" onkeyup="display('inquiry',1,document.getElementById('nrec').value)" placeholder="Search Inquiry" class="form-control" id="ss"/>
                                <div class="input-group-addon">
                                    <font><i class="fa fa-search"></i></font>
                                </div>
                        </div>

           <div id="inquiry" style="margin-top: 5%;" >

           </div>

       </div>
      <?php
     }
}
 ?>      
      

 <!--Manage Service Provider-->  
      
<?php
if(@$_REQUEST['tab']=="servicep")
{
     if($_REQUEST['work']=="display")
     {
     ?>
      <div class="w3-row">
            <div class="w3-row" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('servicep',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input"  style="width: 84%;float: right" type="text" name="usersearch" autofocus="" onkeyup="display('servicep',1,document.getElementById('nrec').value)" placeholder="Search Seller" class="form-control" id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
            <div class="w3-row" id="servicep" >

            </div>
       </div>
      <?php
     }
}
 ?>     
      
 <!--Manage Admin Product-->
      
<?php
if(@$_REQUEST['tab']=="product")
{
     if($_REQUEST['work']=="display")
     {
     ?>
     <div class="w3-row">
            <div class="w3-row" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('product',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            <input class="w3-input"  style="width: 84%;float: right" type="text" name="productsearch" autofocus="" onkeyup="display('product',1,document.getElementById('nrec').value)" placeholder="Search Product" class="form-control" id="ss"/>
        </div>
    </div>

    <div class="w3-row w3-padding-24">
          <div class="w3-row" id="product" style="overflow:auto;">

          </div>
       </div>
      <?php
     }
}
 ?>
 
      
<!-- Manage Service Provider Product-->      
      
<?php
if(@$_REQUEST['tab']=="productsp")
{
     if($_REQUEST['work']=="display")
     {
     ?>
       <div class="w3-row">
            <div class="w3-row" style="font-size: 13px;">
              <div class="w3-threequarter">
                <select class="pagingBox w3-input" onchange="display('productsp',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>

                <input  class="w3-input"  style="width: 84%;float: right" type="text" name="maincategory search" autofocus="" onkeyup="display('productsp',1,document.getElementById('nrec').value)" placeholder="Search Product" class="form-control" id="ss"/>
              </div>
              <div class="w3-quarter">
                <a class="w3-button w3-block" onclick="display('productsp',1,document.getElementById('nrec').value,5)" id="qty" style="background: #E9CE1B;font-weight: bold;color:#fff;width: 80%;margin-left: 15%;">Check Qty Below 5</a>
              </div>
                
            </div>
        </div>

        <div class="w3-row w3-padding-24">
          <div class="w3-row" id="productsp" style="overflow: auto;" >

          </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
      <p class="cityhead">Recycle bin</p>
      <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="input-group">
                  <div class="input-group-addon selcity">
                      <select class="input-control" onchange="recyclebin('rproductsp',1,this.value)" id="nrec" >
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                          <option value="20">20</option>
                      </select>
                  </div>
                  <input type="text" name="maincategorysearch" autofocus="" onkeyup="recyclebin('rproductsp',1,document.getElementById('nrec').value)" placeholder="Search maincategory" class="form-control" id="ss"/>
                  <div class="input-group-addon">
                      <font><i class="fa fa-search"></i></font>
                  </div>
              </div>

              <div id="rproductsp" style="margin-top: 5%;overflow: auto;" >

              </div>

       </div>
      <?php
     }
}
 ?>

      
 
<!--Email Subscrible-->      
      
<?php
if(@$_REQUEST['tab']=="emailsub")
{
    if($_REQUEST['work']=="load")
    {
     ?>
    <p class="cityhead">Load</p>
    <?php
    }

     if($_REQUEST['work']=="display")
     {
     ?>
      <p class="cityhead">Display Email Subscrible</p>
       <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="input-group">
                            <div class="input-group-addon selcity">
                                <select class="input-control" onchange="display('emailsub',1,this.value)" id="nrec" >

                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
          <input type="text" name="emailsearch" autofocus="" onkeyup="display('emailsub',1,document.getElementById('nrec').value)" placeholder="Search Email" class="form-control" id="ss"/>
                                <div class="input-group-addon">
                                    <font><i class="fa fa-search"></i></font>
                                </div>
                        </div>

           <div id="emailsub" style="margin-top: 5%;" >

           </div>
          

       </div>
      
       <div class="col-md-6 col-xs-12 sendmail">
           <p>Send Mail</p>
       
           <form action="" method="post" name="sendmail" class="form-group">
               <table class="table table-responsive">
                   <tr>
                       <td style="padding: 8px 0px 0px 0px;">
                            
                           <input type="text" name="emailtitle" placeholder="Title" class="form-control" style="height:40px;"/>
                       
                       </td>
                   </tr>
                   <tr>
                       <td style="padding: 0px;">
                         
                           <textarea name="detail" class="form-control" style="resize: none;padding: 8% 0% 8% 3%;border:none !important;" placeholder="Message..."></textarea>
                        
                       </td>
                   </tr>
                   <tr>
                       <td style="padding: 0px;">
                         
                           <button onclick="" name="sendmailsub" class="btn btn-danger">Send Mail</button>
                           <button type="reset" name="sendmailsub" class="btn btn-danger">Clear</button>
                        
                       </td>
                   </tr>
               </table>
           </form>
           </div>
      <?php
     }
   
}
 ?>

<!--Services-->      
      
<?php
if(@$_REQUEST['tab']=="service")
{
     if($_REQUEST['work']=="display")
     {
     ?>
     <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="display('service',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
                <input  class="w3-input"  style="width: 84%;float: right" type="text" name="servicesearch" autofocus="" onkeyup="display('service',1,document.getElementById('nrec').value)" placeholder="Search Services"  id="ss"/>
        </div>
    </div>

    <div class="w3-row w3-padding-24">
          <div class="w3-half" id="service" >

          </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
      <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                      <select class="pagingBox w3-input" onchange="recyclebin('rservice',1,this.value)" id="nrec" >
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                          <option value="20">20</option>
                      </select>
                  <input type="text" class="w3-input" style="width: 84%;float: right" name="servicesearch" autofocus="" onkeyup="recyclebin('rservice',1,document.getElementById('nrec').value)" placeholder="Search Service" id="ss"/>
              </div>
       </div>

       <div class="w3-row w3-padding-24">
              <div class="w3-half" id="rservice" >

              </div>
         </div>
      <?php
     }
}
 ?>

<!--Sub Services-->
      
<?php
if(@$_REQUEST['tab']=="subservice")
{
    if($_REQUEST['work']=="load")
    {
     ?>
    <p class="cityhead">Load</p>
    <?php
    }

     if($_REQUEST['work']=="display")
     {
     ?>
      <p class="cityhead">Display Sub Services</p>
       <div class="col-md-8 col-sm-12 col-xs-12">
      <div class="input-group">
                            <div class="input-group-addon selcity">
                                <select class="input-control" onchange="display('subservice',1,this.value)" id="nrec" >

                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
          <input type="text" name="subservicesearch" autofocus="" onkeyup="display('subservice',1,document.getElementById('nrec').value)" placeholder="Search Sub Services" class="form-control" id="ss"/>
                                <div class="input-group-addon">
                                    <font><i class="fa fa-search"></i></font>
                                </div>
                        </div>

           <div id="subservice" style="margin-top: 5%;" >

           </div>

       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
      <p class="cityhead">Recycle bin</p>
      <div class="col-md-8 col-sm-12 col-xs-12">
              <div class="input-group">
                  <div class="input-group-addon selcity">
                      <select class="input-control" onchange="recyclebin('rsubservice',1,this.value)" id="nrec" >
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                          <option value="20">20</option>
                      </select>
                  </div>
                  <input type="text" name="subservicesearch" autofocus="" onkeyup="recyclebin('rsubservice',1,document.getElementById('nrec').value)" placeholder="Search Sub Services" class="form-control" id="ss"/>
                  <div class="input-group-addon">
                      <font><i class="fa fa-search"></i></font>
                  </div>
              </div>

              <div id="rsubservice" style="margin-top: 5%;" >

              </div>

       </div>
      <?php
     }
}
 ?>

<!--Skill-->      
      
<?php
if(@$_REQUEST['tab']=="skill")
{
    if($_REQUEST['work']=="load")
    {
     ?>
    <p class="cityhead">Load</p>
    <?php
    }

     if($_REQUEST['work']=="display")
     {
     ?>
      <p class="cityhead">Display Skill</p>
       <div class="col-md-8 col-sm-12 col-xs-12">
      <div class="input-group">
                            <div class="input-group-addon selcity">
                                <select class="input-control" onchange="display('skill',1,this.value)" id="nrec" >

                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
          <input type="text" name="skillsearch" autofocus="" onkeyup="display('skill',1,document.getElementById('nrec').value)" placeholder="Search Skill" class="form-control" id="ss"/>
                                <div class="input-group-addon">
                                    <font><i class="fa fa-search"></i></font>
                                </div>
                        </div>

           <div id="skill" style="margin-top: 5%;" >

           </div>

       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
      <p class="cityhead">Recycle bin</p>
      <div class="col-md-8 col-sm-12 col-xs-12">
              <div class="input-group">
                  <div class="input-group-addon selcity">
                      <select class="input-control" onchange="recyclebin('rskill',1,this.value)" id="nrec" >
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                          <option value="20">20</option>
                      </select>
                  </div>
                  <input type="text" name="skillsearch" autofocus="" onkeyup="recyclebin('rskill',1,document.getElementById('nrec').value)" placeholder="Search Skill" class="form-control" id="ss"/>
                  <div class="input-group-addon">
                      <font><i class="fa fa-search"></i></font>
                  </div>
              </div>

              <div id="rskill" style="margin-top: 5%;" >

              </div>

       </div>
      <?php
     }
}
 ?>

<!--Package--> 
      
<?php
if(@$_REQUEST['tab']=="package")
{
     if($_REQUEST['work']=="display")
     {
     ?>
    <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="display('package',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <input class="w3-input"  style="width: 84%;float: right" type="text" name="citysearch" autofocus="" onkeyup="display('package',1,document.getElementById('nrec').value)" placeholder="Search Package" class="form-control" id="ss"/>
        </div>
    </div>

    <div class="w3-row w3-padding-24">
        <div class="w3-half" id="package" >

        </div>
    </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
     <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="recyclebin('rpackage',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <input type="text" class="w3-input"  style="width: 84%;float: right" name="packagesearch" autofocus="" onkeyup="recyclebin('rpackage',1,document.getElementById('nrec').value)" placeholder="Search Package" class="form-control" id="ss"/>
        </div>
    </div>
    
    <div class="w3-row w3-padding-24">
              <div class="w3-half" id="rpackage" >

              </div>
         </div>
      <?php
     }
}
 ?>





<!--main category--> 
      
<?php
if(@$_REQUEST['tab']=="maincategory")
{
     if($_REQUEST['work']=="display")
     {
     ?>
     <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="display('maincategory',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <input class="w3-input" style="width: 84%;float: right" type="text" name="maincategory search" autofocus="" onkeyup="display('maincategory',1,document.getElementById('nrec').value)" placeholder="Search Main Category" class="form-control" id="ss"/>
        </div>
    </div>
    
    <div class="w3-row w3-padding-24">
          <div class="w3-half" id="maincategory" >

          </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
      <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="recyclebin('rmaincategory',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input" style="width: 84%;float: right" type="text" name="maincategorysearch" autofocus="" onkeyup="recyclebin('rmaincategory',1,document.getElementById('nrec').value)" placeholder="Search Main Category" class="form-control" id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
              <div class="w3-half" id="rmaincategory" >

              </div>
         </div>
      <?php
     }
}
 ?>




<!--sub category--> 
      
<?php
if(@$_REQUEST['tab']=="subcategory")
{
     if($_REQUEST['work']=="display")
     {
     ?>
    <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="display('subcategory',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <input  class="w3-input"  style="width: 84%;float: right" type="text" name="subcategory search" autofocus="" onkeyup="display('subcategory',1,document.getElementById('nrec').value)" placeholder="Search Sub Category" class="form-control" id="ss"/>
        </div>
    </div>

    <div class="w3-row w3-padding-24">
          <div class="w3-half" id="subcategory" >

          </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
     <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="recyclebin('rsubcategory',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input" style="width: 84%;float: right" type="text" name="subcategorysearch" autofocus="" onkeyup="recyclebin('rsubcategory',1,document.getElementById('nrec').value)" placeholder="Search Sub Category" class="form-control" id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
              <div class="w3-half" id="rsubcategory" >

              </div>
         </div>

       </div>
      <?php
     }
}
 ?>







<!--Peta sub category--> 
      
<?php
if(@$_REQUEST['tab']=="petasubcategory")
{
     if($_REQUEST['work']=="display")
     {
     ?>
     <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="display('petasubcategory',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <input class="w3-input"  style="width: 84%;float: right" type="text" name="petasubcategory search" autofocus="" onkeyup="display('petasubcategory',1,document.getElementById('nrec').value)" placeholder="Search Peta Sub Category" class="form-control" id="ss"/>
        </div>
    </div>

    <div class="w3-row w3-padding-24">
          <div class="w3-half" id="petasubcategory" >

          </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
     <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="recyclebin('rpetasubcategory',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <input class="w3-input" style="width: 84%;float: right" type="text" name="petasubcategorysearch" autofocus="" onkeyup="recyclebin('rpetasubcategory',1,document.getElementById('nrec').value)" placeholder="Search Peta Sub Category" class="form-control" id="ss"/>
        </div>
    </div>

    <div class="w3-row w3-padding-24">
        <div class="w3-half" id="rpetasubcategory" >

        </div>
    </div>

       </div>
      <?php
     }
}
 ?>




<!--Company--> 
      
<?php
if(@$_REQUEST['tab']=="company")
{
     if($_REQUEST['work']=="display")
     {
     ?>
      <div class="w3-row">
            <div class="w3-half"  style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('company',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input type="text" class="w3-input"  style="width: 84%;float: right" name="company search" autofocus="" onkeyup="display('company',1,document.getElementById('nrec').value)" placeholder="Search Brand" class="form-control" id="ss"/>
            </div>
        </div>
        
         <div class="w3-row w3-padding-24">
          <div class="w3-half" id="company" >

          </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
     <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="recyclebin('rcompany',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <input class="w3-input" style="width: 84%;float: right" type="text" name="companysearch" autofocus="" onkeyup="recyclebin('rcompany',1,document.getElementById('nrec').value)" placeholder="Search Company" class="form-control" id="ss"/>
        </div>
    </div>
   <div class="w3-row w3-padding-24">
        <div class="w3-half" id="rcompany" >

        </div>
    </div>
      <?php
     }
}
 ?>
      
      
      
      
      
      
      
<!--Measure--> 
      
<?php
if(@$_REQUEST['tab']=="measure")
{
     if($_REQUEST['work']=="display")
     {
     ?>
    <div class="w3-row">
        <div class="w3-half" style="font-size: 13px;">
            <select class="pagingBox w3-input" onchange="display('measure',1,this.value)" id="nrec" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
          <input class="w3-input"  style="width: 84%;float: right" type="text" name="measure search" autofocus="" onkeyup="display('measure',1,document.getElementById('nrec').value)" placeholder="Search Measure" class="form-control" id="ss"/>
        </div>
    </div>
    
    <div class="w3-row w3-padding-24">
          <div class="w3-half" id="measure" >

          </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
      <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="recyclebin('rmeasure',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            <input class="w3-input" style="width: 84%;float: right" type="text" name="measuresearch" autofocus="" onkeyup="recyclebin('rmeasure',1,document.getElementById('nrec').value)" placeholder="Search Measure" class="form-control" id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
              <div class="w3-half" id="rmeasure" >

              </div>
         </div>
      <?php
     }
}
 ?>
 
      
      
      
      
<!--Highlight--> 
      
<?php
if(@$_REQUEST['tab']=="highlight")
{
    if($_REQUEST['work']=="load")
    {
     ?>
    <p class="cityhead">Load</p>
    <?php
    }

     if($_REQUEST['work']=="display")
     {
     ?>
      <p class="cityhead">Display Highlight</p>
       <div class="col-md-8 col-sm-12 col-xs-12">
      <div class="input-group">
                            <div class="input-group-addon selcity">
                                <select class="input-control" onchange="display('highlight',1,this.value)" id="nrec" >

                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
          <input type="text" name="highlight search" autofocus="" onkeyup="display('highlight',1,document.getElementById('nrec').value)" placeholder="Search Highlight" class="form-control" id="ss"/>
                                <div class="input-group-addon">
                                    <font><i class="fa fa-search"></i></font>
                                </div>
                        </div>

           <div id="highlight" style="margin-top: 5%;" >

           </div>

       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
      <p class="cityhead">Recycle bin</p>
      <div class="col-md-8 col-sm-12 col-xs-12">
              <div class="input-group">
                  <div class="input-group-addon selcity">
                      <select class="input-control" onchange="recyclebin('rhighlight',1,this.value)" id="nrec" >
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                          <option value="20">20</option>
                      </select>
                  </div>
                  <input type="text" name="highlightsearch" autofocus="" onkeyup="recyclebin('rhighlight',1,document.getElementById('nrec').value)" placeholder="Search Highlight" class="form-control" id="ss"/>
                  <div class="input-group-addon">
                      <font><i class="fa fa-search"></i></font>
                  </div>
              </div>

              <div id="rhighlight" style="margin-top: 5%;" >

              </div>

       </div>
      <?php
     }
}
 ?>
      
      
      
      
      
      
      
<!--Banner Pack--> 
      
<?php
if(@$_REQUEST['tab']=="bannerpack")
{
     if($_REQUEST['work']=="display")
     {
     ?>
     <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('bannerpack',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input  class="w3-input"  style="width: 84%;float: right" type="text" name="citysearch" autofocus="" onkeyup="display('bannerpack',1,document.getElementById('nrec').value)" placeholder="Search Banner Package" class="form-control" id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
            <div class="w3-half" id="bannerpack" >

            </div>
       </div>
      <?php
     }
     ?>
      <?php
    if($_REQUEST['work']=="recyclebin")
     {
     ?>
       <div class="w3-row">
            <div class="w3-half" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="recyclebin('rbannerpack',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input" style="width: 84%;float: right" type="text" name="bannerpacksearch" autofocus="" onkeyup="recyclebin('rbannerpack',1,document.getElementById('nrec').value)" placeholder="Search Banner Package" class="form-control" id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
              <div class="w3-half" id="rbannerpack" >

              </div>
         </div>
      <?php
     }
}
 ?>

      
      
<!--Service Provider Banner-->  
      
<?php
if(@$_REQUEST['tab']=="banner")
{
    if($_REQUEST['work']=="load")
    {
     ?>
    <p class="cityhead">Load</p>
    <?php
    }

     if($_REQUEST['work']=="display")
     {
     ?>
      <div class="w3-row">
            <div class="w3-row" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('banner',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input  class="w3-input"  style="width: 84%;float: right" type="text" name="usersearch" autofocus="" onkeyup="display('banner',1,document.getElementById('nrec').value)" placeholder="Search By Store" class="form-control" id="ss"/>
            </div>
        </div>

       <div class="w3-row w3-padding-24">
          <div class="w3-row" id="banner" >

          </div>
       </div>
      <?php
     }
}
 ?>      
      
<!--Manage Service Provider Business-->  
      
<?php
if(@$_REQUEST['tab']=="serviceprovider")
{
     if($_REQUEST['work']=="display")
     {
     ?>
      <div class="w3-row">
            <div class="w3-row" style="font-size: 13px;">
                <select class="pagingBox w3-input" onchange="display('serviceprovider',1,this.value)" id="nrec" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input class="w3-input"  style="width: 84%;float: right" type="text" name="serviceprovidersearch" autofocus="" onkeyup="display('serviceprovider',1,document.getElementById('nrec').value)" placeholder="Search Seller Store" class="form-control" id="ss"/>
            </div>
        </div>

        <div class="w3-row w3-padding-24">
          <div class="w3-row" id="serviceprovider" >

          </div>
       </div>
      
      <?php
     }
}
 ?>
      
      
      
<!-- Missing Workday Service Provider Side-->


<?php
if(@$_REQUEST['kona']=="missworkday")
{
    if($_REQUEST['shu']=="sunday")
    {
        $upsun=  mysqli_query($con,"update workday set sunday=1 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="sunday1")
    {
        $upsun=  mysqli_query($con,"update workday set sunday=0 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="monday")
    {
        $upsun=  mysqli_query($con,"update workday set monday=1 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="monday1")
    {
        $upsun=  mysqli_query($con,"update workday set monday=0 where assignid=$_REQUEST[id]");
    }
     if($_REQUEST['shu']=="tuesday")
    {
        $upsun=  mysqli_query($con,"update workday set tuesday=1 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="tuesday1")
    {
        $upsun=  mysqli_query($con,"update workday set tuesday=0 where assignid=$_REQUEST[id]");
    }
     if($_REQUEST['shu']=="wednesday")
    {
        $upsun=  mysqli_query($con,"update workday set wednesday=1 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="wednesday1")
    {
        $upsun=  mysqli_query($con,"update workday set wednesday=0 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="thursday")
    {
        $upsun=  mysqli_query($con,"update workday set thursday=1 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="thursday1")
    {
        $upsun=  mysqli_query($con,"update workday set thursday=0 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="friday")
    {
        $upsun=  mysqli_query($con,"update workday set friday=1 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="friday1")
    {
        $upsun=  mysqli_query($con,"update workday set friday=0 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="saturday")
    {
        $upsun=  mysqli_query($con,"update workday set saturday=1 where assignid=$_REQUEST[id]");
    }
    if($_REQUEST['shu']=="saturday1")
    {
        $upsun=  mysqli_query($con,"update workday set saturday=0 where assignid=$_REQUEST[id]");
    }
?>
<?php
            $selwk=  mysqli_query($con,"select * from servicesassign where userid like '$_SESSION[user]'");
            while($selwk1=  mysqli_fetch_array($selwk))
            {
                $selwkk=  mysqli_query($con,"select * from workday where assignid=$selwk1[0]");
                $selwkk1=  mysqli_fetch_array($selwkk);
            ?>
        <div class="col-md-10 col-md-offset-1" style="margin-top: 3%;text-transform: capitalize;" >
            <fieldset>
                <legend><?php echo $selwk1[3]; ?></legend>
            </fieldset>
            <div class="row" style="margin: 0;">
                <?php
                if($selwkk1[2]==0)
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','sunday',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#01c38e;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Sunday</p>
                </div>
                <?php
                }
                else
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','sunday1',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#1b1b1b;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Sunday</p>
                </div>
                <?php
                }
                ?>
                <?php
                if($selwkk1[3]==0)
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','monday',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#01c38e;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Monday</p>
                </div>
                <?php
                }
                else
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','monday1',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#1b1b1b;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Monday</p>
                </div>
                <?php
                }
                ?>
                <?php
                if($selwkk1[4]==0)
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','tuesday',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#01c38e;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Tuesday</p>
                </div>
                <?php
                }
                else
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','tuesday1',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#1b1b1b;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Tuesday</p>
                </div>
                <?php
                }
                ?>
                <?php
                if($selwkk1[5]==0)
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','wednesday',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#01c38e;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Wednesday</p>
                </div>
                <?php
                }
                else
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','wednesday1',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#1b1b1b;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Wednesday</p>
                </div>
                <?php
                }
                ?>
                <?php
                if($selwkk1[6]==0)
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','thursday',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#01c38e;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Thursday</p>
                </div>
                <?php
                }
                else
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','thursday1',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#1b1b1b;width: 14%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Thursday</p>
                </div>
                <?php
                }
                ?>
                <?php
                if($selwkk1[7]==0)
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','friday',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#01c38e;width: 13%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Friday</p>
                </div>
                <?php
                }
                else
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','friday1',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#1b1b1b;width: 13%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Friday</p>
                </div>
                <?php
                }
                ?>
                <?php
                if($selwkk1[8]==0)
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','saturday',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#01c38e;width: 13%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Saturday</p>
                </div>
                <?php
                }
                else
                {
                ?>    
                <div class="col-md-1" ondblclick="missworkday('missworkday','saturday1',<?php echo $selwkk1[1];?>);" style="cursor: pointer;margin: 0px 5px 0px 0px;text-align: center;background:#1b1b1b;width: 13%;height: 15%;border-radius: 10px;">
                    <p style="padding-top: 35px;color:#fff;font-size: 24px;">Saturday</p>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <?php
            }
            ?>

<?php
}
?>





<!--Services Service Provider Rate -->
 
 
<?php
if(@$_REQUEST['kona']=="srate")
{
  if(@$_SESSION['user']!="")
  {
  $k=  mysqli_query($con,"select * from rate where userid like '$_SESSION[user]' and assignid=$_SESSION[assid]");
  $kk=  mysqli_fetch_array($k);  
  if($kk[0]=="")
  {
      if($_REQUEST['val']!=0)
      {
        $in=  mysqli_query($con,"insert into rate values(0,$_SESSION[assid],'$_SESSION[user]',$_REQUEST[val])");
      }
  }
  else
  {
      if($_REQUEST['val']!=0)
      {
        $in=  mysqli_query($con,"update rate set rate=$_REQUEST[val] where userid like '$_SESSION[user]' and assignid=$_SESSION[assid]");
      } 
  }
   if(@$_SESSION['user']=="")
   {
   for($i=1;$i<=5;$i++)
   {
   ?>

    <i class="fa fa-bookmark-o srate" title="Give Rate After Login"></i>

    <?php
   }
   }
   else
   {

    ?>
    
    <?php
    $ha=  mysqli_query($con,"select rate from rate where userid like '$_SESSION[user]' and assignid=$_SESSION[assid]");
    $haa=  mysqli_fetch_array($ha);
   
   for($i=1;$i<=5;$i++)
   {
       if($i<=$haa[0])
       {
   ?>
    <i class="fa fa-bookmark srate" style="cursor: pointer;" onclick="srate('srate',<?php echo $i; ?>)"></i>
    <?php
       }
       else
       {
       ?>
        <i class="fa fa-bookmark-o srate" style="cursor: pointer;" onclick="srate('srate',<?php echo $i; ?>)"></i>
       <?php
       }
   }
   }
 }
 else
 {
  for($i=1;$i<=5;$i++)
  {
  ?>
  <i class="fa fa-bookmark-o srate" title="Give Rate After Login"></i>
  <?php
  }
 }
}
?>        

<?php
require_once './connection.php';
require_once './head.php';
?>

<?php

if($_REQUEST['kona']=="misssearch")
{
    if(@$_REQUEST['productid'] != "")
    {
        $pro = mysqli_query($con,"select * from productmaster p,petasubcategory ps where p.productid=$_REQUEST[productid] and p.petasubcatid=ps.petasubcatid");
        $pro1 = mysqli_fetch_array($pro);

        $wish = mysqli_query($con,"insert into wishlist values(0,$_REQUEST[productid],'$_SESSION[user]')");
        
    }

    $str="";
    if(isset($_REQUEST['main']))
    {
        $str=$str."maincatid in (";
        foreach ($_REQUEST['main'] as $data)
        {
            $str=$str.$data.",";
        }
        $str=  rtrim($str,",");
        $str=$str.")";

    }
    
    if(isset($_REQUEST['sub']))
    {
        if($str!="")
        {
            $str=$str." and ";
        }
        
        $str=$str."subcatid in (";
        foreach ($_REQUEST['sub'] as $data)
        {
            $str=$str.$data.",";
        }
        $str=  rtrim($str,",");
        $str=$str.")";

    }

    if(isset($_REQUEST['peta']))
    {
        if($str!="")
        {
            $str=$str." and ";
        }
        
        $str=$str."petasubcatid in (";
        foreach ($_REQUEST['peta'] as $data)
        {
            $str=$str.$data.",";
        }
        $str=  rtrim($str,",");
        $str=$str.")";

    }
    
    if(isset($_REQUEST['brand']))
    {
        if($str!="")
        {
            $str=$str." and ";
        }
        
        $str=$str."companyid in (";
        foreach ($_REQUEST['brand'] as $data)
        {
            $str=$str.$data.",";
        }
        $str=  rtrim($str,",");
        $str=$str.")";

    }
    
    if(isset($_REQUEST['price']))
    {
        if($str!="")
        {
            $str=$str." and ";
        }
        
        $str=$str."(";
        foreach ($_REQUEST['price'] as $data)
        {
            $str=$str."price ".$data." or ";
        }
        $str=  rtrim($str," or");
        $str=$str.")";
    }

    $s=0;
    $e=@$_REQUEST['ketla'];
    if(isset($_REQUEST['search']))
    {
        $pro=  mysqli_query($con,"select p.*,ps.petasubcatname from productmaster p,servicesassign sp,maincategory m,subcategory s,petasubcategory ps,company c where sp.assignid=p.assignid and sp.status=1 and m.maincatid=p.maincatid and s.subcatid=p.subcatid and ps.petasubcatid=p.petasubcatid and c.companyid=p.companyid and (sp.businessname like '$_REQUEST[search]%' or m.maincatname like '$_REQUEST[search]%' or s.subcatname like '$_REQUEST[search]%' or ps.petasubcatname like '$_REQUEST[search]%' or c.companyname like '$_REQUEST[search]%' or p.productid in(select ha.productid from highlight h, assignhighlight ha where h.highlightid=ha.highlightid and h.highlightname like '$_REQUEST[search]%'))");
    }
    else
    {
        if($_REQUEST['ketla']==0 && $str!="")
        {
            $pro=  mysqli_query($con,"select *from productmaster p, servicesassign s where p.verify=1 and s.assignid=p.assignid and s.status=1 and $str");
        }
        else
        {
            if($e==0)
            {
                $e=8;
                $_REQUEST['ketla']=8;
            }
            $pro=  mysqli_query($con,"select *from productmaster p,servicesassign s where p.verify=1 and s.assignid=p.assignid and s.status=1 limit $s,$e");
        }
    }        
        while($pro1=  mysqli_fetch_array($pro))
        {
            $sel=  mysqli_query($con,"select sa.businessname,m.maincatname,s.subcatname,ps.petasubcatname,c.companyname,me.measure from measure me,company c,petasubcategory ps,subcategory s,maincategory m, productmaster p,servicesassign sa where p.productid=$pro1[0] and sa.assignid=p.assignid and m.maincatid=p.maincatid and s.subcatid=p.subcatid and ps.petasubcatid=p.petasubcatid and c.companyid=p.companyid and me.measureid=p.measureid");
            $sel1=  mysqli_fetch_array($sel);
           ?>

                <div class="col-md-3 hovereffect" style="margin-bottom: 2%;" >
                    <div class="row" style='padding: 10px; '>
                        <div>
                           <?php
                                    $selrate=  mysqli_query($con,"select count(*) from rateproduct where productid=$pro1[0]");
                                    $selrate1=  mysqli_fetch_array($selrate);
                                    $selr=  mysqli_query($con,"select sum(rate) from rateproduct where productid=$pro1[0]");
                                    $selr1=  mysqli_fetch_array($selr);
                  
                                    if($selr1[0]==0)
                                    {
                                        for($i=1;$i<=5;$i++)
                                        {
                                            ?>
                                            <i class="fa fa-star-o" style='padding: 2px;'></i>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        $cn=round($selr1[0]/$selrate1[0]);
                                        for($i=1;$i<=5;$i++)
                                        {
                                            if($i<=$cn)
                                            {
                                            ?>
                                            <i class='fa fa-star' style='padding: 2px;color:#E9CE1B;'></i>
                                            <?php    
                                            }
                                            else
                                            {
                                            ?>
                                            <i class='fa fa-star-o' style='padding: 2px;'></i>
                                            <?php
                                            }
                                        }
                                    }
                                    ?>

                                    <?php
                                    if(@$_SESSION['user']!="")
                                    {
                                        $wishl = mysqli_query($con,"select * from wishlist where productid = $pro1[productid] and userid='$_SESSION[user]'");
                                        $wishl1 = mysqli_fetch_array($wishl);
                                        if($wishl1)
                                        {
                                        ?>
                                        <i class="fa fa-heart w3-right" onclick="alert('Already Exist In Wishlist...');" style="margin-right: 5px;color:#FCDE05;"></i>
                                        <?php
                                        }
                                        else
                                        {
                                         ?>
                                         <i class="fa fa-heart w3-right" onclick="misssearch('misssearch',<?php echo $_REQUEST['ketla']; ?>,<?php echo $pro1['productid']; ?>);alert('Added In Wishlist...');" style="margin-right: 5px;color:#C2C2C2;"></i>
                                         <?php   
                                        }    
                                    }
                                    else
                                    {
                                     ?>
                                     <i class="fa fa-heart w3-right" onclick="if(confirm('Please First Login')){window.location.href='sign.php'};" style="margin-right: 5px;color:#C2C2C2;"></i>
                                     <?php   
                                    }
                                    ?>
                                    
                        </div>
                        <div class="col-md-12 productshad" style="padding: 5px;text-align: center;">
                            <a href="productinfo.php?proid=<?php echo $pro1[0]; ?>"><img src="<?php echo $pro1[13]; ?>" class="motophoto" style="width:100%;height:40%;" title="<?php echo $pro1[12]; ?>" class="img img-responsive animated flipInX"/></a>
                        </div>
                        <div class="col-md-12" style="text-align: center;text-transform: capitalize;padding: 5px;font-size: 12px;">
                          <?php 
                          $product = $sel1['petasubcatname']; 
                            $company = $sel1['companyname'];
                            $product = str_replace("$company",'', $product);
                            echo $product;
                          ?>
                        </div>
                        <div class="col-md-6" style="text-align: center;padding: 5px;font-size: 12px;">
                            &#8377; 
                            <?php
                            $price = $pro1['price']-$pro1['discount'];
                            echo "<b>$price</b>";

                            ?>
                            (<del><?php echo $pro1['price']; ?></del>)&nbsp;/-</font>
                        </div>

                        <div class="col-md-6" style="padding: 5px;text-align: center;color:#1b1b1b;font-size: 12px;text-transform: capitalize;">
                            <?php echo $sel1[4]; ?>
                        </div>
                    </div>
                </div>

             <?php
            }
            ?>

            <?php
            $selp=  mysqli_query($con,"select count(*) from productmaster");
            $selp1=  mysqli_fetch_array($selp);
            if(@$_REQUEST['ketla']<=$selp1[0])
            {
                if($str=="")
                {
            ?>      
            <div class="w3-row w3-padding-24">
                <center><a style="color:#000;" onclick="misssearch('misssearch','<?php echo $_REQUEST['ketla']+4; ?>','')"><b>View More Products...</b></a></center>
            </div>
            <?php
                }
            }
            ?>
<?php
}
?>
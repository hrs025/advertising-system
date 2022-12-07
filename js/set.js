function getCounterChart(city,area,customer,contact,feedback)
{
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() 
      {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['City', +city],
          ['Area', +area],
          ['Customer', +customer],
          ['Contact', +contact],
          ['Feedback', +feedback]
        ]);

        var options = {'title':'Counter',
                       'width':1000,
                       'height':600};
        var chart = new google.visualization.PieChart(document.getElementById('counter_chart'));
        chart.draw(data, options);
      }
}


$(document).ready(function(){

    var aCount=0;
     $("#addressClick").click(function(){
        if(aCount==0)
        {
            $("#addressDiv").css("display","none");
            $("#addressClick").attr("class","fa fa-chevron-down w3-right");
            aCount=1;
        }
        else
        {
            $("#addressDiv").css("display","block");
            $("#addressClick").attr("class","fa fa-chevron-up w3-right");
            aCount=0;
        }
    });


    var mcount=0;
     $("#mainIcon").click(function(){
        if(mcount==0)
        {
            $("#maincatdiv").css("display","none");
            $("#mainIcon").attr("class","fa fa-chevron-down w3-right");
            mcount=1;
        }
        else
        {
            $("#maincatdiv").css("display","block");
            $("#mainIcon").attr("class","fa fa-chevron-up w3-right");
            mcount=0;
        }
    });

     var scount=0;
     $("#subIcon").click(function(){
        if(scount==0)
        {
            $("#subcatdiv").css("display","block");
            $("#subIcon").attr("class","fa fa-chevron-up w3-right");
            scount=1;
        }
        else
        {
            $("#subcatdiv").css("display","none");
            $("#subIcon").attr("class","fa fa-chevron-down w3-right");
            scount=0;
        }
    });



     var pcount=0;
     $("#petasubIcon").click(function(){
        if(pcount==0)
        {
            $("#petasubcatdiv").css("display","block");
            $("#petasubIcon").attr("class","fa fa-chevron-up w3-right");
            pcount=1;
        }
        else
        {
            $("#petasubcatdiv").css("display","none");
            $("#petasubIcon").attr("class","fa fa-chevron-down w3-right");
            pcount=0;
        }
    });

     var pcount=0;
     $("#priceIcon").click(function(){
        if(pcount==0)
        {
            $("#pricediv").css("display","none");
            $("#priceIcon").attr("class","fa fa-chevron-down w3-right");
            pcount=1;
        }
        else
        {
            $("#pricediv").css("display","block");
            $("#priceIcon").attr("class","fa fa-chevron-up w3-right");
            pcount=0;
        }
    });

     var bcount=0;
     $("#brandIcon").click(function(){
        if(bcount==0)
        {
            $("#branddiv").css("display","block");
            $("#brandIcon").attr("class","fa fa-chevron-up w3-right");
            bcount=1;
        }
        else
        {
            $("#branddiv").css("display","none");
            $("#brandIcon").attr("class","fa fa-chevron-down w3-right");;
            bcount=0;
        }
    });
    
    $("#trash").mouseover(function(){
        
            $("#trash").html('<i class="fa fa-close"></i>');
            le=1;
            
    });
    $("#trash").mouseleave(function(){
        
            $("#trash").html('<i class="fa fa-trash"></i>');
            le=1;
            
    });
    

    var c=0;

    $("#showlogpassword").click(function(){
        if(c==0)
        {
            $("#logpassword").attr("type","text");
            c=1;
            $("#showlogpassword").attr("class","fa fa-eye-slash");
        }
        else
        {
            $("#logpassword").attr("type","password");
            c=0;
            $("#showlogpassword").attr("class","fa fa-eye");
        }
    });

    var c1=0;

    $("#showregpassword").click(function(){
        if(c1==0)
        {
            $("#password").attr("type","text");
            c1=1;
            $("#showregpassword").attr("class","fa fa-eye-slash");
        }
        else
        {
            $("#password").attr("type","password");
            c1=0;
            $("#showregpassword").attr("class","fa fa-eye");
        }
    });

    var c2=0;

    $("#showregconpassword").click(function(){
        if(c2==0)
        {
            $("#cpassword").attr("type","text");
            c2=1;
            $("#showregconpassword").attr("class","fa fa-eye-slash");
        }
        else
        {
            $("#cpassword").attr("type","password");
            c2=0;
            $("#showregconpassword").attr("class","fa fa-eye");
        }
    });

});

//---------------------------go-to-top-----------------------------------

jQuery(document).ready(function($){
    // browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 300,
    //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
    offset_opacity = 1200,
    //duration of the top scrolling animation (in ms)
    scroll_top_duration = 1000,
    //grab the "back to top" link
    $back_to_top = $('.cd-top');

    //hide or show the "back to top" link
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if( $(this).scrollTop() > offset_opacity ) { 
            $back_to_top.addClass('cd-fade-out');
        }
    });

    //smooth scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0 ,
        }, scroll_top_duration
        );
    });

});

// product MIS Seller Side
function productMIS(tab,purpose,value1,value2)
{
    //alert(tab+" "+purpose+" "+value1+" "+value2);
    $.ajax({
        url:'product-order-mis-ajax.php?tab='+tab+'&purpose='+purpose+'&value1='+value1+'&value2='+value2,
        type:'POST',
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
}

// order MIS Seller Side
function orderMIS(tab,purpose,value1,value2,value3)
{
    //alert(tab+" "+purpose+" "+value1+" "+value2);
    $.ajax({
        url:'product-order-mis-ajax.php?tab='+tab+'&purpose='+purpose+'&value1='+value1+'&value2='+value2+'&value3='+value3,
        type:'POST',
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
}

// product MIS AdminSide
function productMISAdmin(tab,purpose,value1,value2)
{
    //alert(tab+" "+purpose+" "+value1+" "+value2);
    $.ajax({
        url:'product-order-mis-ajax.php?tab='+tab+'&purpose='+purpose+'&value1='+value1+'&value2='+value2,
        type:'POST',
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
}

// order MIS Admin Side
function orderMISAdmin(tab,purpose,value1,value2,value3)
{
    //alert(tab+" "+purpose+" "+value1+" "+value2);
    $.ajax({
        url:'product-order-mis-ajax.php?tab='+tab+'&purpose='+purpose+'&value1='+value1+'&value2='+value2+'&value3='+value3,
        type:'POST',
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
}

function order(tab,purpose,orderid,status,value)
{
    //alert(tab+" "+purpose+" "+orderid+ " "+status+" "+value);
    $.ajax({
        url:'product-order-mis-ajax.php?tab='+tab+'&purpose='+purpose+'&orderid='+orderid+'&status='+status+'&value='+value,
        type:'POST',
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
}


function checkPincode(pincode,storeid)
{
    if(pincode.match('[0-9]{6}'))
    {
        $.ajax({
            url:'mainmiss.php?pincode='+pincode+'&storeid='+storeid,
            type:'POST',
            success:function (data)
            {
                $("#pincodeDiv").html(data);
            }
        });
    }
    else
    {
        alert('Only 6 Digit Pincode Allowed...');
    }
}

function wishlist(tab,wishid)
{
    $.ajax({
        url:'mainmiss.php?tab='+tab+'&wishid='+wishid,
        type:'POST',
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
}

function checkout(tab,address,shippingid,cartid,purpose,cqty)
{
   //alert(tab+" "+address+" "+shippingid+" "+cartid+" "+purpose+" "+cqty);
    var data = $("#addressData").serializeArray();
    $.ajax({
        url:'checkout_ajax.php?tab='+tab+'&address='+address+'&shippingid='+shippingid+'&cartid='+cartid+'&purpose='+purpose+'&cqty='+cqty,
        type:'POST',
        data:data,
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
}

function cart(tab,cartid,purpose,cqty)
{
    //alert(tab+" "+cartid+" "+purpose+" "+cqty);
    $.ajax({
        url:'mainmiss.php?tab='+tab+'&cartid='+cartid+'&purpose='+purpose+'&cqty='+cqty,
        type:'POST',
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
    
}

function display(tab,p,pp,qty)
{
  
   var s=document.getElementById('ss').value;
   //alert(tab+" "+p+" "+" "+pp+" "+s+" "+qty);
    $.ajax({
        url:'misstable.php?tab='+tab+'&p='+p+'&pp='+pp+'&search='+s+'&qty='+qty,
        type:'POST',
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
}

function recyclebin(tab,p,pp)
{
   var s=document.getElementById('ss').value;
    $.ajax({
        url:'misstable.php?tab='+tab+'&p='+p+'&pp='+pp+'&search='+s,
        type:'POST',
        success:function (data)
        {
            $("#"+tab).html(data);
        }
    });
}

function del(tab,p,pp,delid,ek)
{
   var s=document.getElementById('ss').value;
     $.ajax({
            url:'misstable.php?tab='+tab+'&p='+p+'&pp='+pp+'&search='+s+'&delid='+delid+'&ek='+ek,
            type:'POST',
            success:function (data)
            {
                $("#"+tab).html(data);
            }
        });
}

function up(tab,p,pp,upid)
{
    //alert(tab + " "+ p+" "+pp+" "+upid);
   var s=document.getElementById('ss').value;
     $.ajax({
            url:'misstable.php?tab='+tab+'&p='+p+'&pp='+pp+'&search='+s+'&upid='+upid,
            type:'POST',
            success:function (data)
            {
                $("#"+tab).html(data);
            }
        });
}

function update(tab,p,pp,updateid,upval)
{   

   var s=document.getElementById('ss').value;
   // alert(tab+" "+p+" "+" "+pp+" "+s+" "+updateid+" "+upval);
     $.ajax({
            url:'misstable.php?tab='+tab+'&p='+p+'&pp='+pp+'&search='+s+'&updateid='+updateid+'&upval='+upval,
            type:'POST',
            success:function (data)
            {
                $("#"+tab).html(data);
            }
        });
}

function updatemulti(tab,p,pp,upmulid)
{
    var m=$("#mydata").serialize();
    var s=document.getElementById('ss').value;
   $.ajax({
            url:'misstable.php?tab='+tab+'&p='+p+'&pp='+pp+'&search='+s+'&upmulid='+upmulid,
            type:'POST',
            data:m,
            success:function (data)
            {
                $("#"+tab).html(data);
            }
        }); 
}

function delrecycle(tab,p,pp,delid)
{
    //alert(tab+" "+p+" "+pp+" "+delid);
        $.ajax({
            url:'misstable.php?tab='+tab+'&p='+p+'&pp='+pp+'&delid='+delid,
            type:'POST',
            success:function (data)
            {
                $("#"+tab).html(data);
            }
        });
}
function restore(tab,p,pp,upid)
{
   //alert(tab+" "+p+" "+pp+" "+upid);
        $.ajax({
            url:'misstable.php?tab='+tab+'&p='+p+'&pp='+pp+'&upid='+upid,
            type:'POST',
            success:function (data)
            {
                $("#"+tab).html(data);
            }
        });
   
}


function miss(tab,work)
{
    
    $.ajax({
        url:'mainmiss.php?tab='+tab+'&work='+work,
        type:'POST',
        success:function (data)
        {
            $("#miss"+tab).html(data);
             if(work == "display")
             {
                display(tab,1,5);
             }
             if(work == "recyclebin")
             {
                 recyclebin('r'+tab,1,5);
             }
        }
    });
   
}



function getreg(shu)
{
    $.ajax({
        url:'capchamiss.php?shu='+shu,
        type:'POST',
        success:function(info)
        {
            $("#capcha").html(info);
        }
    });
}



function ccounter(tab,total)
{
    var s=0;
    var jovu=$("#"+tab);
    var c=setInterval(function(){
        s++;
        jovu.text(s);
        if(s>=total)
        {
            clearInterval(c);
        }
        
    },40);
}

function getarea(cityid)
{
    $.ajax({
        url:'misstable.php?cityid='+cityid,
        type:'POST',
        success:function(data)
        {
            $("#area").html(data);
        }
    });
}

function misscat(kayutable,val)
{
    $.ajax({
        url:'misstable.php?kayutable='+kayutable+'&val='+val,
        type:'POST',
        success:function(data)
        {
            $("#"+kayutable).html(data);
        }
    });
}


function missbill(kona,konu,stid)
{
    $.ajax({
        url:'misstable.php?kona='+kona+'&konu='+konu+'&stid='+stid,
        type:'POST',
        success:function(data)
        {
            $("#"+kona).html(data);
        }
    });
}


function missuserbill(kona,konu)
{

    $.ajax({
        url:'misstable.php?kona='+kona+'&konu='+konu,
        type:'POST',
        success:function(data)
        {
            $("#"+kona).html(data);
        }
    });
}

function foll(kona)
{
    $.ajax({
        url:'misstable.php?kona='+kona,
        type:'POST',
        success:function(data)
        {
            $("#missservicecontact").html(data);
        }
    });
}



function seapack(kona,koni,shu)
{
    $.ajax({
        url:'misstable.php?kona='+kona+'&koni='+koni+'&shu='+shu,
        type:'POST',
        success:function(data)
        {
            $("#packmis").html(data);
        }
    });
}

function serviceproviderseapack(kona,koni,shu)
{
    $.ajax({
        url:'misstable.php?kona='+kona+'&koni='+koni+'&shu='+shu,
        type:'POST',
        success:function(data)
        {
            $("#serviceproviderseapack").html(data);
        }
    });
}

function seapackproduct(kona,koni,shu)
{
    $.ajax({
        url:'misstable.php?kona='+kona+'&koni='+koni+'&shu='+shu,
        type:'POST',
        success:function(data)
        {
            $("#productpackmis").html(data);
        }
    });
}


function seapackproductm(kona,koni,shu)
{
    $.ajax({
        url:'misstable.php?kona='+kona+'&koni='+koni+'&shu='+shu,
        type:'POST',
        success:function(data)
        {
            $("#mproductpackmis").html(data);
        }
    });
}




function grate(kona,val)
{
    $.ajax({
        url:'misstable.php?kona='+kona+'&val='+val,
        type:'POST',
        success:function(data)
        {
            $("#ratedekho").html(data);
        }
    });
}

function prate(kona,val)
{
    //alert(kona+""+val);
    $.ajax({
        url:'misstable.php?kona='+kona+'&val='+val,
        type:'POST',
        success:function(data)
        {
            $("#pratedekho").html(data);
        }
    });
}

function srate(kona,val)
{
    //alert(kona+""+val);
    $.ajax({
        url:'mainmiss.php?kona='+kona+'&val='+val,
        type:'POST',
        success:function(data)
        {
            $("#"+kona).html(data);
        }
    });
}

function missprice(qty,price)
{
    var quantity=document.getElementById("quantity").value;
    document.getElementById("quantity1").value=quantity;
    var ans=(qty)*(price);
    $("#missp").text(ans);
}

function getwish(tab,id)
{
    $.ajax({
        url:'misstable.php?tab='+tab+'&id='+id,
        type:'POST',
        success:function(data)
        {
            $("#"+tab).html(data);
        }
    });
}


function misscart(kona,cid,q)
{
    $.ajax({
        url:'misstable.php?kona='+kona+'&cid='+cid+'&q='+q,
        type:'POST',
        success:function(data)
        {
            $("#misscart").html(data);
        }
    });
}

function confirmcart(kona)
{
    $.ajax({
        url:'misstable.php?kona='+kona,
        type:'POST',
        success:function(data)
        {
            $("#confirmcart").html(data);
        }
    });
}


function missship(kona,shu)
{
    $.ajax({
        url:'misstable.php?kona='+kona+'&shu='+shu,
        type:'POST',
        success:function(data)
        {
            $("#maruaddress").html(data);
        }
    });
    if(shu!=0)
    {
        $("#maruaddress").slideUp(1000);
    }
}


function misspbill(kona,shu,data)
{
    $.ajax({
        url:'misstable.php?kona='+kona+'&shu='+shu+'&data='+data,
        type:'POST',
        success:function(data)
        {
            $("#"+kona).html(data);
        }
    });
}


function sellerbill(kona,shu,data)
{
   var lp,hp;
   if(data!=0)
   {
       lp=$("#lp").val();
       hp=$("#hp").val();
   }
 
    $.ajax({
        url:'misstable.php?kona='+kona+'&shu='+shu+'&data='+data+'&lp='+lp+'&hp='+hp,
        type:'POST',
        success:function(data)
        {
            $("#"+kona).html(data);
        }
    });
}

function codecoupen(codelavo)
{
    a=codelavo;
    $("#code").text(a);
}
function coupensum(code,ftot)
{
    c=code;
    if(c==$("#textcode").val())
    {
        
        $("#hidetr").slideUp(1000);
        ft=ftot;
        cdiscount=Math.ceil((ft*2)/100);
        $("#cdis").text(cdiscount);
        $("#totdis").val(cdiscount);
        tt=ftot-cdiscount+30;
        ttax=Math.ceil((tt*2)/100);
        $("#stax").text(ttax);
        tp=ttax+tt;
        $("#tp").text(tp);
        $("#tottext").val(tp);
    }
    else
    {
       $("#invalmsg").text("Invalid Code")
    }
    
    
}


function missworkday(kona,shu,id)
{

    $.ajax({
        url:'mainmiss.php?kona='+kona+'&shu='+shu+'&id='+id,
        type:'POST',
        success:function(data)
        {
            $("#"+kona).html(data);
        }
    });
}

//miss search
function misssearch(kona,ketla,productid)
{
    //alert(kona+" "+ketla);
    var d=$("#filter").serialize();
        $.ajax({
            url:'misssearch.php?kona='+kona+'&ketla='+ketla+'&productid='+productid,
            type:'POST',
            data:d,
            success:function(data)
            {
                $("#misssearch").html(data);
            }
        });
}

function searchfilter(search,kona)
{
    $.ajax({
        url:'misssearch.php?search='+search+'&kona='+kona,
        type:'POST',
        success:function(data)
        {
            $("#misssearch").html(data);
        }
    });
}

function servicebook(kai,val)
{
    $.ajax({
        url:'misstable.php?kai='+kai+'&val='+val,
        type:'POST',
        success:function(data)
        {
            $("#"+kai).html(data);
        }
    });
}


ccn=0;
function searchbox(str)
{
    if(str=="open")
    {
        $("#search-pan").css("display","block");
    }
    if(str=="close")
    {
        if(ccn==0)
        {
             $("#search-pan").css("display","none");
        }
    }
}

function combocount(cn)
{
    ccn=cn;
}
function globalsearch(str)
{
    $.ajax({
        url:'mysearch.php?search='+str,
        type:'POST',
        success:function (data)
        {
            $('#search-pan').html(data);
        }
    });
}
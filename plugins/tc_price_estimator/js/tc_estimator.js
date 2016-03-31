/* 
 * This is the javascript file for all of the ajax and other on Big Sky Horse Leasing llc website
 */
$ = jQuery.noConflict();

$(document).ready(function(){
    
    /*******************************************
     * Validation for the register page
     * this goes on for a while, to find the 
     * Price Estimator look down a ways
     * *****************************************
     */
    $.ajaxSetup ({
        // Disable caching of AJAX responses */
            cache: false
        });
        
   /********************************************
    * Processes for the Price Estimator
    * ******************************************
    * 
    * Set the number of horses to the value of 
    * the form value
    * ******************************************
    */
   $('#number_of_horses').keyup(function(){
        cart.numberOfHorses();
   });
   
   /************************************************
    * get the total lease amount depending on what 
    * the user chooses as a lease duration
    * **********************************************
    */
    $('#lease_duration').change(function(){
        cart.leasePrice();
    });
    
    /************************************************
     * Get the hauling charges using the numbers the
     * user filled out on the rest of the form
     * **********************************************
     */
    $('#miles').keyup(function(){
        cart.haulingTotal();
    });
    
    /*************************************************
     * Get the total shoeing costs
     * ***********************************************
     */
    $('#shoeing_rate').change(function(){
        cart.shoeingTotal();
    });
    
    /*************************************************
     * Get the total for riding packages
     * ***********************************************
     */
    $('#riding_packages').keyup(function(){
        cart.ridingPackage();
    });
    
    /*************************************************
     * Get the total for the pack packages
     * ***********************************************
     */
    $('#pack_packages').keyup(function(){
        cart.packPackage();
    });
    
    /*************************************************
     * Get the total for Saddle bags
     * ***********************************************
     */
    $('#saddle_bags').keyup(function(){
        cart.saddleBagsTotal();
    });
    
    /*************************************************
     * Get the total for rawlide boxes
     *************************************************
     */
    $('#rawlide_boxes').keyup(function(){
        cart.rawlideBoxesTotal();
    });
    
    /*************************************************
     * Get the total for hobbles
     * ***********************************************
     */
    $('#hobbles').keyup(function(){
        cart.hobblesTotal();
    });
    
    /*************************************************
     * Get the total for scabbards
     * ***********************************************
     */
    $('#scabbards').keyup(function(){
        cart.scabbardsTotal();
    });
    
    /**************************************************
     * Get the total for ropes
     * ************************************************
     */
    $('#ropes').keyup(function(){
        cart.ropesTotal();
    });
    
    /**************************************************
     * Get the total for tent and stove
     * ************************************************
     */
    $('#tents').change(function(){
        cart.tentsTotal();
    });
    
    /**************************************************
     * Change the tents total when the stove checkbox
     * ************************************************
     */
    $('#stove').change(function(){
        cart.stoveChange();
    });
    
    /***************************************************
     * A click on the calculate button triggers the 
     * ajax call that sends all of the information 
     * to the server and gets the total prices for 
     * the lease and the third down.
     * 
     * An array is sent back from the server and 
     * I split it in the function that is called 
     * here.  
     * 
     * The information is then calculated in the 
     * methods of the cart object and placed in the 
     * web page.
     * *************************************************
     */
    $('#calculate').click(function(){
        verify.checkForCalculate();
        // the calculate method is run in the verify 
        // object below.
    });

    /**************************************************
     * End of the Price Estimator methods
     * ************************************************
     */
     
});



/******************************************************
 * These are the functions that are used by the events
 * above
 * ****************************************************
 */
var cart = {
    
    // function to set the number of horses in the price estimator
    numberOfHorses:function(){
        var horses = $('#number_of_horses').val();
            if(isNaN(horses)){
                $('#horse_errors_holder').fadeIn(2000).html('<div class="est-errors">(Number of Horses must be a number!)</div>');
            }else{
                var leaseVal = $('#lease_duration').val();
                var shoeing = $('#shoeing_rate').val();
                var hidden = $('#hidden_shoeing_rate').val();
                
                    $('#horse_errors_holder').fadeOut(2000);
                    $('#number_of_horses_total').html(horses + ' horses');
                    if(isNaN(leaseVal) || leaseVal === 0){
                        return false;
                    }else{
                        this.leasePrice();
                        if(shoeing === hidden){
                            this.shoeingTotal();
                        }
                    }     
            }
    },// End of the numberOfHorses function
    
    // function to get the total price of horses
    leasePrice:function(){
        var leaseRate = $('#lease_duration').val();
        var horses = $('#number_of_horses').val();
        var horseTotal = $('#number_of_horses_total').val();
        
           
            if(horses === '' || horses === 0){
                $('#horse_errors_holder').fadeIn(2000).html('<div class="est-errors">(You must select a number of horses first!)</di>');
            } else if( horses > 15 ) { 
                $('#horse_errors_holder').fadeIn(2000).html('<div class="est-success">( For 15 or more horses, please contact us for special rates. )</di>');
            } else {
                var total = horses * leaseRate;
                $('#lease_price').html('$' + total + '.00');

                if( leaseRate == 425 ) {
                    $('#shoeing_div').fadeOut(2000);
                    $('#shoeing_errors_holder').fadeIn(2000).html('<div class="est-success">(Short Term Leases already include shoes)</div>');
                } else {
                    $('#shoeing_div').fadeIn(2000);
                    $('#shoeing_errors_holder').fadeOut(2000);
                }
            }
    },// End of the leasePrice method
    
    // method to get the total for hauling
    haulingTotal:function(){
        var miles = $('#miles').val();
        var rate = $('#hauling_rate').val();
        var numRate = rate.toFixed;
        var haulingTotal = (miles * (rate * 100)) / 100;
        var haulingBothWays = haulingTotal * 2;
        var rounded = Math.round(haulingBothWays);
        if(isNaN(miles)){
            $('#miles_errors_holder').fadeIn(2000).html('<div class="est-errors">(The number of miles has to be a number!)</div>');
         } else {
            $('#miles_errors_holder').fadeOut(2000);
            $('#hauling_price').html('$' + rounded + '.00');
         }
    },// End of the haulingTotal method
    
    // method to get the total shoeing cost
    shoeingTotal:function(){
        var leaseRate = $('#lease_duration').val();
        var shortRate = $('#hidden_short_term_rate').val();
        var shoeingRate = $('#shoeing_rate').val();
        var horses = $('#number_of_horses').val();
        var shoeing = horses * shoeingRate;
        
        if(leaseRate === shortRate && shoeingRate !== 'no' && shoeingRate !== 'empty'){
            $('#shoeing_errors_holder').fadeIn(2000).html('<div class="est-success">(Short Term Leases already include shoes)</div>');
            $('#shoeing_price').html('$0.00');
            $('#shoeing_rate').val('empty');
        }else if(leaseRate !== shortRate && shoeingRate !== 'no' && shoeingRate !== 'empty'){
            $('#shoeing_errors_holder').fadeOut(2000);
            $('#shoeing_price').html('$' + shoeing + '.00');
        }else{
            $('#shoeing_errors_holder').fadeOut(2000);
            $('#shoeing_price').html('$0.00');
        }
    },// this is the End of the shoeingTotal method
    
    // method to get the total for the riding packages
    ridingPackage:function(){
        var ridingPackages = $('#riding_packages').val();
        var ridingPackageRate = $('#hidden_riding_packages_rate').val();
        var ridingPackageTotal = ridingPackages * ridingPackageRate;
        
        if(isNaN(ridingPackages)){
            $('#tack_errors_holder').fadeIn(2000).html('<div class="est-errors">(Riding Packages must have a number!)</div>');
        }else{
            $('#tack_errors_holder').fadeOut(2000);
            $('#riding_packages_price').html('$' + ridingPackageTotal + '.00');
        }
    },// End if the Riding Packages method 
    
    // method to get the total for the pack packages
    packPackage:function(){
        var packPackages = $('#pack_packages').val();
        var packPackageRate = $('#hidden_pack_packages_rate').val();
        var packPackageTotal = packPackages * packPackageRate;
        
        if(isNaN(packPackages)){
            $('#tack_errors_holder').fadeIn(2000).html('<div class="est-errors">(Pack Packages must have a number!)</div>');
        }else{
            $('#tack_errors_holder').fadeOut(2000);
            $('#pack_packages_price').html('$' + packPackageTotal + '.00');
        }
    },// End if the Pack Packages method 
    
    // method to get the total for the saddle bags
    saddleBagsTotal:function(){
        var saddleBags = $('#saddle_bags').val();
        var saddleBagRate = $('#hidden_saddle_bag_rate').val();
        var saddleBagsVal = saddleBags * saddleBagRate;
        
        if(isNaN(saddleBags)){
            $('#accessory_errors_holder').fadeIn(2000).html('<div class="est-errors">(Saddle Bags must have a number!)</div>');
        }else{
            $('#accessory_errors_holder').fadeOut(2000);
            $('#saddle_bags_price').html('$' + saddleBagsVal + '.00');
        }
    },// End if the saddle bags method 
    
    // method to get the total for the rawlide boxes
    rawlideBoxesTotal:function(){
        var rawlideBoxes = $('#rawlide_boxes').val();
        var rawlideBoxRate = $('#hidden_rawlide_box_rate').val();
        var rawlideBoxVal = rawlideBoxes * rawlideBoxRate;
        
        if(isNaN(rawlideBoxes)){
            $('#accessory_errors_holder').fadeIn(2000).html('<div class="est-errors">(Rawlide Boxes must have a number!)</div>');
        }else{
            $('#accessory_errors_holder').fadeOut(2000);
            $('#rawlide_boxes_price').html('$' + rawlideBoxVal + '.00');
        }
    },// End if the rawlide boxes method 
    
    // method to get the total for hobbles
    hobblesTotal:function(){
        var hobbles = $('#hobbles').val();
        var hobblesRate = $('#hidden_hobbles_rate').val();
        var hobblesVal = hobbles * hobblesRate;
        
        if(isNaN(hobbles)){
            $('#accessory_errors_holder').fadeIn(2000).html('<div class="est-errors">(Hobbles must have a number!)</div>');
        }else{
            $('#accessory_errors_holder').fadeOut(2000);
            $('#hobbles_price').html('$' + hobblesVal + '.00');
        }
    },// End if the hobbles method 
    
    // method to get the total for scabbards
    scabbardsTotal:function(){
        var scabbards = $('#scabbards').val();
        var scabbardsRate = $('#hidden_scabbards_rate').val();
        var scabbardsVal = scabbards * scabbardsRate;
        
        if(isNaN(scabbards)){
            $('#accessory_errors_holder').fadeIn(2000).html('<div class="est-errors">(Scabbards must have a number!)</div>');
        }else{
            $('#accessory_errors_holder').fadeOut(2000);
            $('#scabbards_price').html('$' + scabbardsVal + '.00');
        }
    },// End if the scabbards method 
    
    // method to get the total for ropes
    ropesTotal:function(){
        var ropes = $('#ropes').val();
        var ropesRate = $('#hidden_ropes_rate').val();
        var ropesVal = ropes * ropesRate;
        
        if(isNaN(ropes)){
            $('#accessory_errors_holder').fadeIn(2000).html('<div class="est-errors">(Ropes must have a number!)</div>');
        }else{
            $('#accessory_errors_holder').fadeOut(2000);
            $('#ropes_price').html('$' + ropesVal + '.00');
        }
    },// End if the ropes method 
    
    // method to get the total for tents and stove
    tentsTotal:function(){
        var tents = $('#tents').val();
        var stove = $('#stove').attr('checked');
        
        if(stove === 'checked' && tents !== 'empty'){
            var stoveVal = $('#stove').val();
            var tentAndStove = Number(tents) + Number(stoveVal);
            $('#tents_price').html('$' + tentAndStove + '.00');
        }else if(tents === 'empty'){
            $('#tents_price').html('$0.00');
        }else{
            $('#tents_price').html('$' + tents + '.00');
        }
    }, // End of the tents method
    
    // method to change tents total if stove is clicked
    stoveChange:function(){
        var stove = $('#stove').attr('checked');
        var stoveVal = $('#stove').val();
        var tentsVal = $('#tents').val();
        
        if(stove === 'checked' && tentsVal !== 0 && tentsVal !== 'empty'){
            var newTents = (Number(stoveVal)+Number(tentsVal));
            $('#tents_price').html('$' + newTents + '.00');
        }else{
            if(tentsVal !== 'empty'){
                $('#tents_price').html('$' + tentsVal + '.00');
            }else{
                $('#tents_price').html('$0.00');
            }
        }
    },// End of change stove method
    
    // method to send the ajax request to the server to 
    // get the array to figure the totals and the third
    // down
    calculate:function(){
        // set all the variables to be sent as post data
        var horses = $('input[name="number_horses"]').val();
        var leaseRate = $('#lease_duration').val();
        var hauling = $('#miles').val();
        var shoeing = $('#shoeing_rate').val();
        var numRiding = $('#riding_packages').val();
        var numPacking = $('#pack_packages').val();
        var numSaddleBags = $('#saddle_bags').val();
        var numRawlideBoxes = $('#rawlide_boxes').val();
        var numHobbles = $('#hobbles').val();
        var numScabbards = $('#scabbards').val();
        var numRopes = $('#ropes').val();
        var tentsVal = $('#tents').val();
        var stoveVal = $('#stove').attr('checked');
        
        var estData  = {
            horses: horses,
            lease_rate: leaseRate,
            hauling: hauling,
            shoeing: shoeing,
            num_riding: numRiding,
            num_packing: numPacking,
            num_saddle_bags: numSaddleBags,
            num_rawlide_boxes: numRawlideBoxes,
            num_hobbles: numHobbles,
            num_scabbards: numScabbards,
            num_ropes: numRopes,
            tent_val: tentsVal,
            stove_val: stoveVal
        }

        $.post( tcest.ajaxURL, {
            data: estData,
            action: "tc_calculate_totals"
        }, function( data ) {

            $('#lease_total').html('$' + data['leasing_total'] + '.00');
            $('#accessories_total').html('$' + data['accessories_total'] + '.00');
            $('#total').html('$' + data['grand_total'] + '.00');
            $('#down_payment').html('$' + data['down_payment'] + '.00');

        }, "json");
    }
    
}// this is the closing tag for the cart object

// Start of verify Object
var verify = {

    // Check values before calculating
    checkForCalculate:function(){

        var horses = $('input[name="number_horses"]').val();

        if(isNaN(horses) || horses == 0 || !horses ) {
            $('#main_lease_errors_holder').fadeIn(2000).html('<div class="est-errors">(You must enter a valid number of horses before calculating!)</div>');
        } else {
            $('#main_lease_errors_holder').fadeOut(2000);
            cart.calculate();
        }

    }

}// This is the closing tag for the verify objece

// Start of links Object
var links = {

    // this method changes all the links with the linkId that you supply as 
    // an argument.  There are two arguments that need to be supplied, the 
    // class name that you want to target and the href that you want to 
    // replace the link with 
    setLinks:function(linkClass,newAttr){
        $.each($('.' + linkClass), function(i){
            var itemId = $(this).attr('id');
            $(this).attr('href',newAttr + '/' + itemId);
        });
    }

}

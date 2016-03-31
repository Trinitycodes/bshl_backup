<?php
/**
 * Template Namne: BSHL Price Estimator
 *
 * @package Genesis\Templates
 * @author  Trinity Vandenacre
 * @license GPL-2.0+
 * @link    http://trinitycodes.com
 */

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Load the Estimator
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_before_loop', 'trin_display_estimator' );


function trin_display_estimator() {

        // Set the rates array
        $custom_fields = get_post_custom( 200 );

        $text = '';

        foreach( $custom_fields as $key => $value ) {

            foreach( $value as $index => $rate ) {

                $rates_array[$key] = $rate;

            }

        }

        echo $text;

	?>

		<h1>Price Estimator</h1>

        <form action="<?php echo get_site_url(); ?>rates/estimator" method="post">

            <div id="horse_errors_holder"></div>
        
        	<div class="one-third first">

                    Enter the number of horses that you want to lease

            </div>
            <div class="one-third">

            	<input type="text" name="number_horses" id="number_of_horses" size="4" maxlength="2">

            </div>
            <div class="one-third">

            	<div id="container_price">
                    <div id="number_of_horses_total">0 horses</div>
                </div>

            </div>

            <!-- Start New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Select the lease duration

            </div>
            <div class="one-third">

            	<select name="duration" id="lease_duration">
            		<option value="empty" selected="selected"></option>
            		<option value="<?php echo $rates_array['short-term'] ? $rates_array['short-term'] : 0; ?>">Summer (Under 14 days)</option>
            		<option value="<?php echo $rates_array['summer-season'] ? $rates_array['summer-season'] : 0; ?>">Summer (May 1st - Sept 1st)</option>
                    <option value="<?php echo $rates_array['extended-summer-season'] ? $rates_array['extended-summer-season'] : 0; ?>">Summer Extended (May 1st - Oct 1st)</option>
            		<option value="<?php echo $rates_array['short-term'] ? $rates_array['short-term'] : 0; ?>">Fall (Under 14 days)</option>
            		<option value="<?php echo $rates_array['fall-season'] ? $rates_array['fall-season'] : 0; ?>">Fall (Over 14 days)</option>
            	</select>

            </div>
            <div class="one-third">

            	<div id="container_price">

            		<div id="lease_price">$0.00</div>

            	</div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Hauling, Enter the number of miles, one way from our ranch to your destination. Need help? Go to <span id="container_link"><a href="http://www.mapquest.com/">mapquest.com</a></span> and figure the distance to your destination from <span style="color: #660000;">(25 White Horse Rd, Townsend, MT 59644)</span>.

            </div>
            <div class="one-third">

            <div id="miles_errors_holder"></div>

            	<input type="text" id="miles" name="hauling" size="4">
            	<input type="hidden" id="hauling_rate" value="<?php echo $rates_array['hauling'] ? $rates_array['hauling'] : 0; ?>">

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="hauling_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Shoeing (Choose yes if you want your horses shod)

            </div>
            <div class="one-third">

                <div id="shoeing_errors_holder"></div>

                <div id="shoeing_div">

                	<select name="shoeing" id="shoeing_rate">
                		<option selected="selected" value="empty"></option>
                		<option value="no">No</option>
                		<option value="<?php echo $rates_array['shoeing'] ? $rates_array['shoeing'] : 80; ?>">Yes</option>
                        <option value="<?php echo $rates_array['special-shoeing'] ? $rates_array['special-shoeing'] : 110; ?>">Special</option>
                	</select>
                	<input type="hidden" id="hidden_shoeing_rate" value="<?php echo $rates_array['shoeing'] ? $rates_array['shoeing'] : 80; ?>" />

                </div>

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="shoeing_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div>

            	<h3>Tack Packages</h3>
            	<div id="tack_errors_holder"></div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Enter number of Riding Packages

            </div>
            <div class="one-third">

            	<input type="text" id="riding_packages" name="riding_packages" size="4">
            	<input type="hidden" id="hidden_riding_packages_rate" value="<?php echo $rates_array['tack-package'] ? $rates_array['tack-package'] : 100; ?>">

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="riding_packages_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Enter number of Pack Packages

            </div>
            <div class="one-third">

            	<input type="text" name="pack_packages" id="pack_packages" size="4">
            	<input type="hidden" id="hidden_pack_packages_rate" value="<?php echo $rates_array['tack-package'] ? $rates_array['tack-package'] : 100; ?>">

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="pack_packages_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div>

            	<h3>Accessories</h3>
            	<div id="accessory_errors_holder"></div>

            </div>

            <!-- Start a New Row without an hr -->
            
            <div class="one-third first">

            	Saddle Bags $<?php echo $rates_array['saddle-bags'] ? $rates_array['saddle-bags'] : 15; ?> Each

            </div>
            <div class="one-third">

            	<input type="text" name="saddle_bags" id="saddle_bags" size="4">
            	<input type="hidden" id="hidden_saddle_bag_rate" value="<?php echo $rates_array['saddle-bags'] ? $rates_array['saddle-bags'] : 15; ?>">

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="saddle_bags_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Rawlide Pack Boxes $<?php echo $rates_array['hard-side-boxes'] ? $rates_array['hard-side-boxes'] : 80; ?> per Set

            </div>
            <div class="one-third">

            	<input type="text" name="rawlide_boxes" id="rawlide_boxes" size="4">
            	<input type="hidden" id="hidden_rawlide_box_rate" value="<?php echo $rates_array['hard-side-boxes'] ? $rates_array['hard-side-boxes'] : 80; ?>">

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="rawlide_boxes_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Hobbles $<?php echo $rates_array['hobbles'] ? $rates_array['hobbles'] : 80; ?> each

            </div>
            <div class="one-third">

            	<input type="text" id="hobbles" name="hobbles" size="4">
            	<input type="hidden" id="hidden_hobbles_rate" value="<?php echo $rates_array['hobbles'] ? $rates_array['hobbles'] : 80; ?>">

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="hobbles_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Scabbards $<?php echo $rates_array['rifle-scabbard'] ? $rates_array['rifle-scabbard'] : 80; ?> each

            </div>
            <div class="one-third">

            	<input type="text" id="scabbards" name="scabbards" size="4">
            	<input type="hidden" id="hidden_scabbards_rate" value="<?php echo $rates_array['rifle-scabbard'] ? $rates_array['rifle-scabbard'] : 80; ?>">

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="scabbards_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Ropes $<?php echo $rates_array['ropes'] ? $rates_array['ropes'] : 80; ?> each

            </div>
            <div class="one-third">

            	<input type="text" name="ropes" id="ropes" size="4">
            	<input type="hidden" id="hidden_ropes_rate" value="<?php echo $rates_array['ropes'] ? $rates_array['ropes'] : 80; ?>">

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="ropes_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            <div class="one-third first">

            	Wall Tent

            </div>
            <div class="one-third">

            	<select name="tents" id="tents">
            		<option value="empty"></option>
            		<option value="<?php echo $rates_array['12x14-wall-tent'] ? $rates_array['12x14-wall-tent'] : 80; ?>">(12 x 14 Wall Tent)</option>
            		<option value="<?php echo $rates_array['10x12-wall-tent'] ? $rates_array['10x12-wall-tent'] : 80; ?>">(10 x 12 Wall Tent)</option>
            	</select>
            	<input type="checkbox" name="stove" value="<?php echo $rates_array['stove'] ? $rates_array['stove'] : 80; ?>" id="stove">

            </div>
            <div class="one-third">

            	<div id="container_price">

                    <div id="tents_price">$0.00</div>

                </div>

            </div>

            <!-- Start a New Row -->
            <div style="clear: both;" class="clearfix"><hr></div>

            
            <div class="one-half first">

            	<div class="wrap">

            		<div class="one-half first">

            			Lease Price

            		</div>
            		<div class="one-half">

            			<span id="container_price"><span id="lease_total">$0.00</span></span>

            		</div>

            	</div>
            	<div class="wrap">

            		<div class="one-half first">

            			Accessories

            		</div>
            		<div class="one-half">

            			<span id="container_price"><span id="accessories_total">$0.00</span></span>

            		</div>

            	</div>
            	<div class="wrap">

            		<div class="one-half first">

            			Grand Total

            		</div>
            		<div class="one-half">

            			<span id="container_price"><span id="total">$0.00</span></span>

            		</div>

            	</div>
            	<div class="wrap">

            		<div>
            			<span style="color: #000000; font-size: 15px; font-weight: normal;">(To guarantee the horses you must put 1/3 of the total down)</span>
            		</div>

            		<div class="one-half first">

            			1/3 Down Payment

            		</div>
            		<div class="one-half">

            			<span id="container_price"><span id="down_payment">$0.00</span></span>

            		</div>

            	</div>

                

            </div>

            <div class="one-half">

                <!-- Button for Calculating Totals -->
                <div class="button" id="calculate">Calculate Totals</div>
                <div id="main_lease_errors_holder"></div>

            </div>
            

            <div style="clear: both; padding: 4em;"></div>

	<?php

}

genesis();
?>
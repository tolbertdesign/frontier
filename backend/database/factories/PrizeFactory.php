<?php

use Faker\Generator as Faker;
use App\Entities\Prize;

$factory->define(Prize::class, function (Faker $faker) {
    $prizes = collect([
        [
            'name'                   => 'CH5 - Sky Flyer',
            'inventory_code'         => 'Pr-20',
            'picture'                => '38fe6b09_Unknown.jpeg',
            'video'                  => 'https://vimeo.com/90117546',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'CH5 - Camp Band',
            'inventory_code'         => 'CH5-P1',
            'picture'                => '4336a73c_1-CampBand.jpg',
            'video'                  => '88676708',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'CH5 - Invisible Ink Pen',
            'inventory_code'         => 'CH5-P2',
            'picture'                => '2b6bcef9_2-InvisibleInkPen.jpg',
            'video'                  => '88676709',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'CH5 - High Five Lunchbox',
            'inventory_code'         => 'CH5-P7',
            'picture'                => '0ae1fdea_7-HighFiveLunchbox.jpg',
            'video'                  => '88676713',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'CH5 - Flying Gyro Ball',
            'inventory_code'         => 'CH5-P20',
            'picture'                => '563c792f_20-FlyingGyroBall.jpg',
            'video'                  => '88676941',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'CH5 - Alpine Racer',
            'inventory_code'         => 'CH5-P50',
            'picture'                => '471fda75_50-AlpineRacer.jpg',
            'video'                  => '88676949',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'AFO Flyer',
            'inventory_code'         => 'Pr-15',
            'picture'                => '22b7c3ef_Unknown-1.jpeg',
            'video'                  => '90117417',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Chick-Fil-A', 'inventory_code' => 'WC-2',
            'picture'                => '147f4a2c_chick-fil-a-logo.png',
            'video'                  => 'NULL',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Homework Pass',
            'inventory_code'         => 'MS-3',
            'picture'                => '4ec279f8_Screen_Shot_2013-08-20_at_2.00_.22_PM_.png',
            'video'                  => 'NULL',
            'salesforce_id'          => null
        ],
        [
            'name'                   => '$10 Gift Card',
            'inventory_code'         => 'MS-10',
            'picture'                => '19df6d40_Screen_Shot_2013-08-20_at_2.03_.54_PM_.png',
            'video'                  => 'NULL',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Smoothie',
            'inventory_code'         => 'MS-Sm',
            'picture'                => '49c15816_smoothie.jpeg',
            'video'                  => 'NULL',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Dress Down Pass',
            'inventory_code'         => 'MS-Dress',
            'picture'                => '5594593d_Screen_Shot_2013-08-26_at_8.34_.50_AM_.png',
            'video'                  => 'NULL',
            'salesforce_id'          => null
        ],
        [
            'name'                   => '$15 TARGET GIFTCARD',
            'inventory_code'         => 'ms-15tgc',
            'picture'                => '2bee84a6_Screen_Shot_2013-09-12_at_12.46_.31_PM_.png',
            'video'                  => 'NULL',
            'salesforce_id'          => null
        ],
        [
            'name'                   => '$20 VISA GIFTCARD',
            'inventory_code'         => 'ms-20vgc',
            'picture'                => '5a25e1ef_Screen_Shot_2013-09-12_at_12.46_.36_PM_.png',
            'video'                  => 'NULL',
            'salesforce_id'          => null
        ],
        [
            'name'                   => '$100 AMAZON GIFT CARD',
            'inventory_code'         => 'ms-100agc',
            'picture'                => '59403e9e_Screen_Shot_2013-09-12_at_12.48_.30_PM_.png',
            'video'                  => 'NULL',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'CHICK-FIL-A MILKSHAKE',
            'inventory_code'         => 'ms-cfams',
            'picture'                => '053dbfda_Screen_Shot_2013-09-12_at_12.49_.05_PM_.png',
            'video'                  => 'NULL',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Delicious Donut Delivery - TRES',
            'inventory_code'         => 'TRES-1',
            'picture'                => '1.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Popcorn Palooka - TRES',
            'inventory_code'         => 'TRES-2',
            'picture'                => '2.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Mystery Prize - TRES',
            'inventory_code'         => 'TRES-5',
            'picture'                => '5.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Party Bus - TRES',
            'inventory_code'         => 'TRES-10',
            'picture'                => '10.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Italian Ice - TRMS',
            'inventory_code'         => 'TRMS-2',
            'picture'                => '2ms.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Pizza Lunch - TRMS',
            'inventory_code'         => 'TRMS-3',
            'picture'                => '3ms.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Party Bus - TRMS',
            'inventory_code'         => 'TRMS-10',
            'picture'                => '10ms.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Secret Pocket Band',
            'inventory_code'         => 'BBO-PRZ-1300',
            'picture'                => '0_-_Secret_Pocket_Band.jpg',
            'video'                  => '177927689',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Pop Flinger',
            'inventory_code'         => 'BBO-PRZ-1302',
            'picture'                => '1_-_Pop_Flinger.jpg',
            'video'                  => '177927678',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Shoe Swag',
            'inventory_code'         => 'BBO-PRZ-1301',
            'picture'                => '2_-_Shoe_Swag.jpg',
            'video'                  => '177927679',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Light Up Bungee Rocket',
            'inventory_code'         => 'BBO-PRZ-1303',
            'picture'                => '3_-_Light_Up_Bungee_Rocket.jpg',
            'video'                  => '177927817',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Rev Copter',
            'inventory_code'         => 'BBO-PRZ-1304',
            'picture'                => '5_-_Rev_Copter.jpg',
            'video'                  => '177927681',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Scoop-N-Sling',
            'inventory_code'         => 'BBO-PRZ-1306',
            'picture'                => '10_-_Scoop-N-Sling.jpg',
            'video'                  => '177927683',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Pop Up Soccer Set',
            'inventory_code'         => 'BBO-PRZ-1307',
            'picture'                => '15_-_Pop_Up_Soccer_Set.jpg',
            'video'                  => '177927947',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Micro Stunt Flyer',
            'inventory_code'         => 'BBO-PRZ-1308',
            'picture'                => '20_-_Micro_Stunt_Flyer.jpg',
            'video'                  => '177927948',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Booster Speaker Cube',
            'inventory_code'         => 'BBO-PRZ-1309',
            'picture'                => '30_-_Booster_Speaker_Cube.jpg',
            'video'                  => '177927686',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBO - Sbyke',
            'inventory_code'         => 'BBO-PRZ-1310',
            'picture'                => '50_-_Sbyke.jpg',
            'video'                  => '177927688',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Emoticon Light Up Ball',
            'inventory_code'         => 'porter-1perlap',
            'picture'                => '1_Emoticon_Light_Up_Ball.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Light Up Spinner',
            'inventory_code'         => 'porter-2perlap',
            'picture'                => '2_Light_Up_Spinner.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Flying Disc',
            'inventory_code'         => 'porter-3perlap',
            'picture'                => '3_18_flying_disc_.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Giant Tennis Ball',
            'inventory_code'         => 'porter-5perlap',
            'picture'                => '5_8_Giant_Tennis_Ball.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Power Card to Dave & Busters',
            'inventory_code'         => 'porter-10perlap',
            'picture'                => '10_Power_Card_to_Dave_Busters.jpeg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Drone',
            'inventory_code'         => 'porter-15perlap',
            'picture'                => '15_Drone.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'iFly Indoor Skydiving',
            'inventory_code'         => 'porter-20perlap',
            'picture'                => '20_iFLY_Indoor_Skydiving.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Razor A5 Scooter',
            'inventory_code'         => 'porter-30perlap',
            'picture'                => '25_Razor_A5_Scooter.jpeg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Run for Rock Ridge T-Shirt',
            'inventory_code'         => 'Rock Ridge - 0.5 per lap (t-shirt)',
            'picture'                => '1.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Fidget Spinner',
            'inventory_code'         => 'Rock Ridge - $1 per lap (fidgit spinner)',
            'picture'                => '2.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Chance to Dunk a Teacher',
            'inventory_code'         => 'Rock Ridge - $2 per lap (teacher dunk)',
            'picture'                => '3.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Kone Ice Ticket + 1 Principal Dunk',
            'inventory_code'         => 'Rock Ridge - $4 per lap (kona ice)',
            'picture'                => '4.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Bounce House Obstacle Course Time',
            'inventory_code'         => 'Rock Ridge - $6 per lap (bounce house)',
            'picture'                => '5.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Xbox or $250 American Girl Gift Card',
            'inventory_code'         => 'Rock Ridge - $50 per lap (xbox/american girl)',
            'picture'                => '10.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Travis Ranch Elem - Gobble Up a Gourmet Lollipop',
            'inventory_code'         => 'TR-Elem-35f',
            'picture'                => '1.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Travis Ranch Elem - LED Flashing UFO Spinning Top',
            'inventory_code'         => 'TR-Elem-100f',
            'picture'                => '2.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Travis Ranch Elem - Silly String War',
            'inventory_code'         => 'TR-Elem-150f',
            'picture'                => '3.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Travis Ranch Elem - Glow Arcade Party""',
            'inventory_code'         => 'TR-Elem-350f',
            'picture'                => '4.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Travis Ranch Elem - Take a Party Bus to Lunch',
            'inventory_code'         => 'TR-Elem-550',
            'picture'                => '5.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Travis Ranch Elem - Spin the Wheel of Fortune""',
            'inventory_code'         => 'TR-Elem-1000f',
            'picture'                => '10.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Travis Ranch Elem - Apple Ipod Touch',
            'inventory_code'         => 'TR-Elem-2000f',
            'picture'                => '11.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Little - 1 Raffle Ticket',
            'inventory_code'         => 'LES-reg',
            'picture'                => '1_raffle_ticket_-_little_elem.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Legacy Christian - $250 Best Buy Gift Card',
            'inventory_code'         => 'LCS-Sp18-2000flat',
            'picture'                => '250_Best_Buy_Gift_Card.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Porter Yo-Yo',
            'inventory_code'         => 'sp18-porter-1ppl',
            'picture'                => '1_Yo-Yo.JPG',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Porter Flashing Emoji Balls',
            'inventory_code'         => 'sp18-porter-3ppl',
            'picture'                => '3_Flashing_Emoji_Balls.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Porter Ear Buds',
            'inventory_code'         => 'sp18-porter-5ppl',
            'picture'                => '5_Ear_Buds.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Porter Flying Disco Ball',
            'inventory_code'         => 'sp18-porter-15ppl',
            'picture'                => '15_Flying_Disco_Ball.JPG',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Porter Razor Scooter',
            'inventory_code'         => 'sp18-porter30ppl',
            'picture'                => '30_Razor_Scooter.jpeg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Porter Super Hero Keychain',
            'inventory_code'         => 'sp18-porter-2ppl',
            'picture'                => '2_Super_Hero_Keychain.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Porter NRH20 Day Ticket',
            'inventory_code'         => 'sp18-porter-10ppl',
            'picture'                => '10_NRH2O_Day_Ticket.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Porter Flashing Yo-Yo Ball',
            'inventory_code'         => 'sp18-porter-3ppl-revised',
            'picture'                => '3_Flashing_Yo-Yo_Ball.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'MML - MindSpark Gears (10)',
            'inventory_code'         => 'MML-PRZ-1301',
            'picture'                => '1-10_Mindspark_Gears.jpg',
            'video'                  => '278943796',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'MML - Booster Team Headband',
            'inventory_code'         => 'MML-PRZ-1302',
            'picture'                => '2-Booster_Team_Headband.jpg',
            'video'                  => '278943803',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'MML - Glow Rocket',
            'inventory_code'         => 'MML-PRZ-1303',
            'picture'                => '3-Glow_Rocket.jpg',
            'video'                  => '278943807',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'MML - Crush Bottle',
            'inventory_code'         => 'MML-PRZ-1304',
            'picture'                => '5-Crush_Bottle.jpg',
            'video'                  => '278943817',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'MML - Trampoline Ball',
            'inventory_code'         => 'MML-PRZ-1306',
            'picture'                => '10-Trampoline_Ball.jpg',
            'video'                  => '278943877',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'MML - Disc Jam',
            'inventory_code'         => 'MML-PRZ-1307',
            'picture'                => '15-Disc_Jam.jpg',
            'video'                  => '278944093',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'MML - Booster DJ Headphones',
            'inventory_code'         => 'MML-PRZ-1308',
            'picture'                => '20-Booster_DJ_Headphones.jpg',
            'video'                  => '278943881',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'MML - Booster Skycopter',
            'inventory_code'         => 'MML-PRZ-1309',
            'picture'                => '30-Booster_Skycopter.jpg',
            'video'                  => '278943888',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'MML - Electric Scooter',
            'inventory_code'         => 'MML-PRZ-1310',
            'picture'                => '50-Booster_Scooter.jpg',
            'video'                  => '278943896',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Be Proactive wrist band + Water bottle + 1 raffle ticket',
            'inventory_code'         => 'GE - 1',
            'picture'                => '1st_pledge.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'First things first wrist band + Extra Computer Time Coupon + 1 raffle ticket',
            'inventory_code'         => 'GE - 2',
            'picture'                => '50.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Synergize wrist band + Picnic Lunch with Mrs. Lindberg and Mrs. Allen' .
                                        ' + 1 raffle ticket',
            'inventory_code'         => 'GE - 4',
            'picture'                => '125.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Paw Spirit Lanyard',
            'inventory_code'         => 'Fall18-Pop-$25 ',
            'picture'                => '25_Level_jpgpoplar.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Large Coyote Plush',
            'inventory_code'         => 'Fall18-Pop-$150',
            'picture'                => '150_level_jpgpoplar.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Gobble Up a Gourmet Lollipop',
            'inventory_code'         => 'Fall18-TR-$35',
            'picture'                => '35_Travis_Ranch.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Silly String War',
            'inventory_code'         => 'Fall18-TR-$250',
            'picture'                => '3.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Arcade Party Spend your lunch in the Middle School Arcade',
            'inventory_code'         => 'Fall18-TR-$350',
            'picture'                => '4.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => '25 Min. Extra Recess with Snow Cones',
            'inventory_code'         => 'FAll18-SLDM-$100',
            'picture'                => '100_SLDM.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Flying Disco Ball Drone',
            'inventory_code'         => 'Fall18-WA-$15PPL',
            'picture'                => '15_Flying_Disco_Ball.JPG',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Razor Scooter',
            'inventory_code'         => 'Fall18-WA-$30PPL',
            'picture'                => '30_Razor_Scooter.jpeg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Superhero Glider',
            'inventory_code'         => 'Fall18-GL-$1',
            'picture'                => '1_PPL.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Superhero Wristband',
            'inventory_code'         => 'Fall18-GL-$2',
            'picture'                => '2_PPL.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Foam Sword',
            'inventory_code'         => 'Fall18-GL-$3',
            'picture'                => '3_PPL.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Superhero Cape & Mask',
            'inventory_code'         => 'Fall18-GL-$5',
            'picture'                => '5_PPL.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Airplane Glider',
            'inventory_code'         => 'Fall18-GL-$10',
            'picture'                => '10_PPL.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Flying Ball Helicopter',
            'inventory_code'         => 'Fall18-GL-$15',
            'picture'                => '15_PPL.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Hover Soccer Ball Set',
            'inventory_code'         => 'Fall18-GL-$20',
            'picture'                => '20_PPL.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Scooter',
            'inventory_code'         => 'Fall18-GL-$30',
            'picture'                => '30_PPL.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'BBQ',
            'inventory_code'         => 'Williams-Spring18-$200',
            'picture'                => '200_Williams.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Gift Certificate to School Store',
            'inventory_code'         => 'NBES$35',
            'picture'                => '35_Gift_Certificate_to_School_Store.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'LED Glow Baton',
            'inventory_code'         => 'NBES_$50',
            'picture'                => '50_LED_Glow_Baton.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'NBES Water Bottle',
            'inventory_code'         => 'NBES_$100',
            'picture'                => '100_NBES_Water_Bottle.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'VIP Lunch Table (invite a friend and enjoy dessert)',
            'inventory_code'         => 'NBES_$250',
            'picture'                => '250_VIP_Lunch_Table_(invite_a_friend_and_enjoy_dessert).png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'Trip to Playstation during school with Mini Gold, Unlimited Games, Snacks ' .
                                        '& a Goodie Bag!!',
            'inventory_code'         => 'NBES_$300',
            'picture'                => '300_Trip_to_Play_Staytion_during_school_with_mini_golf,_unlimited_games,' .
                                        '_snacks_a_goodie_bag!.png',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => '2019 Neon Shutter Glasses',
            'inventory_code'         => 'Cameron-19-$450',
            'picture'                => '2019_Neon_Shutter_Glasses.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
        [
            'name'                   => 'LED Poi Ball Swirling Light',
            'inventory_code'         => 'SL-19-$200',
            'picture'                => '51dY6-YPIUL__SY450_.jpg',
            'video'                  => '',
            'salesforce_id'          => null
        ],
            ]);

    $prize = $prizes->random();
    sleep(.25);
    while (Prize::where('name', $prize['name'])->exists()) {
        echo 'Existsing Prize: ' . $prize['name'];
        $prize = $prizes->random();
    }
    return $prize;
});

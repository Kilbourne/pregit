<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php   use Roots\Sage\Extras;
  if( function_exists ('wc_google_analytics_pro' )){
  $tracking = wc_google_analytics_pro()->get_integration();

remove_action( 'wp_head',  array( $tracking, 'ga_tracking_code' ), 9 );

      add_action( 'body_open',  function() use ($tracking) { Extras\ga_tracking_code($tracking);}, 1 );
      }
      wp_head(); ?>
      <meta name="google-site-verification" content="qW7Iwcut0nCnDeqjX91qUshR8OOGR6hhcwaXQnwd5u4" />
</head>

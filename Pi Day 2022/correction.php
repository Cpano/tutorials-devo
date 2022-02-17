function wpf_dev_email_message_custom_styles( $message ) {

$custom_styles =
'
#templateBody {
background-color: #32a852;
}

@import
url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

*{
font-family: 'Open Sans', sans-serif;
padding: 0px;
}

.S1-Welcome{
background-image: url('https://314piday.com/wp-content/uploads/2022/02/Email-B1.jpg');
color: #fff;
background-size: cover;
}

#templateBody .mcnTextContent a {
color:#32a852;
font-weight:normal;
text-decoration:underline;
}
';

$message = preg_replace('/<style type="text\/css">(.*?)<\/style>/s', '<style type="text/css">$1' . $custom_styles . '
</style>', $message);

return $message;

}

add_filter( 'wpforms_email_message', 'wpf_dev_email_message_custom_styles', 10, 1);
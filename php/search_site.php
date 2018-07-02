<?php

print(phpinfo());
$db_file = "/res/posts_db.json";

# Thank you to https://stackoverflow.com/questions/828870/php-regex-how-to-get-
# the-string-value-of-html-tag for the code snippet.
function getTextBetweenTags($string, $tagname) {
  $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
  preg_match($pattern, $string, $matches);

  return $matches[1];
}

function updateDatabase() {
  # Create array which is the database
  $database = array();

  # Fill in the "hash"... basically prevents this function if no new data has been added
  $database['lastUpdate'] = 
    shell_exec("ls -l /html/dynamic/ | grep posts | awk '{print $6 $7 $8}'");

  $database['posts'] = array();
  $database['tags'] = array();

  # Iterate through the different blog posts and strip the meta data out of them.
  foreach (glob("/html/dynamic/posts/*.html") as $post) {
    $current_post_meta = array();
    $post_buffer = file_get_contents($post);
    
    $title = explode(" | ", getTextBetweenTags($post_buffer, "title"))[0];
    $date = getTextBetweenTags($post_buffer, "date");
    $tags = explode(",", getTextBetweenTags($post_buffer, "tags"));

    $current_post_meta['title'] = $title;
    $current_post_meta['tags'] = $tags;
    $current_post_meta['date'] = $date;

    foreach ($tags as $tag) {
      if (array_key_exists($tag, $current_post_meta['tags'])) {
        $current_post_meta['tags'][$tag] += 1;
      } else {
        $current_post_meta['tags'][$tag] = 1;
      }
    }

    $database['posts'].append($current_post_meta);
  }

  arsort($database['tags']);

  $db_handle = fopen($db_file, 'w') or die("Cannot open database file: " . $db_file);
  fwrite($db_handle, $db_out = json_encode($database));
  fclose($db_handle);

  return $database;
}

## Begin search script
# 
# $keystring = $_POST['keystring'];
# $keytag = $_POST['keytags'];
# 
# $db_data = "none";
# 
# if (file_exists($db_file)) {
#   $db_data_raw = file_get_contents($db_file);
#   $db_data = json_decode($db_file);
# 
#   if ($db_data['lastUpdate'] != 
#       shell_exec("ls -l /html/dynamic/ | grep posts | awk '{print $6 $7 $8}'")) {
# 
#     $db_data = updateDatabase();
#   }
# } else {
#     $db_data = updateDatabase();
# }
# 
# echo(json_encode($db_data));

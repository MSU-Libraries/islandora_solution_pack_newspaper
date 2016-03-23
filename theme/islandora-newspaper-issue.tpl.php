<?php

/**
 * @file
 */
?>
<?php module_load_include('inc', 'islandora_solr_search'); ?>
<div class="islandora-newspaper-issue clearfix">
  <span class="islandora-newspaper-issue-navigator">
    <?php print theme('islandora_newspaper_issue_navigator', array('object' => $object)); ?>
  </span>
  <?php if (isset($viewer_id) && $viewer_id != "none"): ?>
    <div id="book-viewer">
      <?php print $viewer; ?>
    </div>
  <?php else: ?>
    <?php print theme('islandora_objects', array('objects' => $pages)); ?>
  <?php endif; ?>
  <div class="islandora-newspaper-issue-metadata">
    <?php print $description; ?>
    <?php print $metadata; ?>
  </div>

  <div id="pdf-link">
      <p><a href='/islandora/object/<?php print $object?>/datastream/PDF' target='_blank'>View PDF</a><p>
  </div>

  <div id="newspaper-metadata">
      <?php
          $pid = $object;
          $solr = new Apache_Solr_Service('localhost',8080,'/solr/fedcom/');
          $query = 'PID:("' . $pid .'")';
          $limit = 10;
          $settings = array("wt"=>"json");
          $results = $solr->search($query, 0, $limit, $settings);
          $json_results = json_decode($results->getRawResponse(), true);
          $json_results["response"]["docs"];
       ?>
       <ul>
       <li><span class='metadata-heading'>TITLE</span> <span class="metadata-value"><?php print $json_results["response"]["docs"][0]["dc.title"][0]; ?></span></li>
       <li><span class='metadata-heading'>PUBLISHER</span> <span class="metadata-value"><?php print $json_results["response"]["docs"][0]["dc.publisher"][0]; ?></span></li>
       <li><span class='metadata-heading'>DATE</span> <span class="metadata-value"><?php print $json_results["response"]["docs"][0]["dc.date"][0]; ?></span></li>
       </ul>
  </div>
</div>



<?php $datetime = $row->{'field_' . $field->field}[0]['raw']['value']; ?>
<?php $day = format_date(strtotime($datetime), 'custom', 'd'); ?>
<?php $month = format_date(strtotime($datetime), 'custom', 'M'); ?>
<div class="views-field-field-annoncement-date">
  <span class="day"><?php echo $day; ?></span>
  <span class="month"><?php echo $month; ?></span>
</div>

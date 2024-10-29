<?php
function copyrights_ws_images_setInfo($res, $methodName, $params)
{
  if ($methodName != 'pwg.images.setInfo')
  {
    return $res;
  }
  if (!isset($params['image_id']))
  {
    return $res;
  }
  if (!isset($params['copyrights']))
  {
    return $res;
  }

  if (!empty($params['copyrights']))
  {
    if (!preg_match(PATTERN_ID, $params['copyrights']))
    {
      return new PwgError(WS_ERR_INVALID_PARAM, 'Invalid input parameter copyrights');
    }
    $query = '
INSERT INTO ' . COPYRIGHTS_MEDIA . ' 
  (media_id, cr_id)
  VALUES
  (' . $params['image_id'] . ', ' . $params['copyrights'] . ')
  ON DUPLICATE KEY UPDATE
    cr_id = ' . $params['copyrights'] . '
;';
  
    pwg_query($query);
  }
  else
  {
    $query = '
DELETE FROM ' . COPYRIGHTS_MEDIA . '
  WHERE media_id = ' . $params['image_id'] . '
;';
    pwg_query($query);
  }

  return $res;
}

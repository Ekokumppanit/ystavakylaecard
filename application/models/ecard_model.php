<?php

/**
 * Ecard
 */
class Ecard_model extends MY_Model
{
    public $before_create = array( 'timestamps' );

    public function __construct()
    {
        parent::__construct();
    }

    public function formatPost($data = null)
    {
        $format = $data;
        unset(
            $format['from_page'],
            $format['page']
        );

        $format = $format['data'];

        if (empty($format)) {
            return false;
        } else {
            foreach ($format as $card_id => $item) {
                unset($card_id, $item);
            }

        }
        return $format;
    }

    public function createCard(
        $cardPath = null,
        $cardHead = '',
        $cardText = '',
        $cardHeadPlace = array(),
        $cardTextPlace = array(),
        $cardHeadSize = array(),
        $cardTextSize = array(),
        $cardSize = array()
    ) {

        if (empty($cardSize)) {
            $cardSize["w"] = 800;
            $cardSize["h"] = 600;
        }

        if (empty($cardHeadSize)) {
            $cardHeadSize["w"] = 600;
            $cardHeadSize["h"] = 200;
        }

        if (empty($cardTextSize)) {
            $cardTextSize["w"] = 600;
            $cardTextSize["h"] = 200;
        }

        // If we don't have card, use default
        if (empty($cardPath) || ! is_readable($cardPath)) {
            $cardPath = FCPATH . 'assets/basecards/1.jpg';
        }

        // Header text place, 5x35 from top left corner
        if (empty($cardHeadPlace)) {
            $cardHeadPlace["x"] = 5;
            $cardHeadPlace["y"] = 35;
        }

        // Text place defaults, 30 px lower than header text
        if (empty($cardTextPlace)) {
            $cardTextPlace["x"] = 5;
            $cardTextPlace["y"] = 65;
        }

        // Create image resource and allocate background as white
        $rImg = ImageCreateFromJPEG($cardPath);

        // Image size
        $img_w = imagesx($rImg);
        $img_h = imagesy($rImg);

        $ratio = cardSizeRatio(
            $img_w,
            $img_h,
            $cardSize['w'],
            $cardSize['h']
        );

        // Calculate difference between preview and real
        $head_x = $cardHeadPlace['x'] * $ratio['w'];
        $head_y = $cardHeadPlace['y'] * $ratio['h'];
        $text_x = $cardTextPlace['x'] * $ratio['w'];
        $text_y = $cardTextPlace['y'] * $ratio['h'];

        // Set white color to white
        $white = imagecolorallocate($rImg, 255, 255, 255);

        // Header text
        // resource, text size, angle, x, y, color, font file, text
        if (! empty($cardHead)) {
            imagettftext(
                $rImg,
                40,
                0,
                $head_x, //$cardHeadPlace["x"],
                $head_y, //$cardHeadPlace["y"],
                $white,
                HEADERTEXT,
                $cardHead
            );
        }

        // Content text
        // resource, text size, angle, x, y, color, font file, text
        if (! empty($cardText)) {
            imagettftext(
                $rImg,
                28,
                0,
                $text_x, //$cardTextPlace["x"],
                $text_y, //$cardTextPlace["y"],
                $white,
                BODYTEXT,
                $cardText
            );
        }

        // Return our image as png
        return $rImg;
    }

    /**
     * showCard displays image resource
     *
     * @param resource $rImg Image resource from memory
     *
     * @return image         PNG File
     */
    public function showCard($rImg = null)
    {
        if (empty($rImg) || ! is_resource($rImg)) {
            return false;
        }

        header('Content-Type: image/png');
        imagepng($rImg, null, 9, PNG_FILTER_PAETH);
        imagedestroy($rImg);
    }

    public function saveCard($rImg = null, $name = null)
    {
        if (empty($rImg) || ! is_resource($rImg)) {
            return false;
        }

        $image = imagepng($rImg, CARDPATH . $name . '.png', 9, PNG_FILTER_PAETH);
        imagedestroy($rImg);

        if ($image) {
            return $name;
        } else {
            return false;
        }
    }

    public function saveCards($cardData = null)
    {
        if (empty($cardData)) {
            return false;
        }

        foreach ($cardData as $id => $data) {
            try {
                $this->ecard->update($id, $data);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return true;
    }

    /**
     * countStatuses
     * Get numbers for card statuses
     *
     * @return object Contains numbers for all, queued, private, public and hidden
     */
    public function countStatuses()
    {
        $return = new stdClass();

        // Our type counts, default to zero amount
        $return->all     = 0;
        $return->queue   = 0;
        $return->private = 0;
        $return->public  = 0;
        $return->hidden  = 0;

        // Count amounts
        $result = $this->db->select("COUNT(*) num, card_status")
            ->group_by("card_status")
            ->get($this->_table)
            ->result_object();

        // Make easier to use
        if (!empty($result)) {
            foreach ($result as $count) {
                $return->{$count->card_status} = $count->num;
                $return->all += $count->num;
            }
        }

        // Return our defaults, or our counts
        return $return;
    }

    protected function timestamps($ecard)
    {
        $ecard['created_at'] = $ecard['updated_at'] = date('Y-m-d H:i:s');
        return $ecard;
    }
}

<?
class xPartners extends Items{

    public function showLogos($partnerType, $columns = 0){
        $partners = $this->listingWhereLike("id_xPartnerTypes", $partnerType, "sequence", "ASC", 0, 0);
        $i = 0;
        foreach($partners AS $partner){
            if($columns) echo "<div class='medium-$columns columns $i text-center'>";
                $path = getFirstMediaPath("xPartners", $partner["id"], "img", "");
                echo "<a title='".$partner["xPartners"]."' href='".$partner["url"]."' target='_blank'><img src='".$path."' alt='".$partner["xPartners"]."'></a>";
            if($columns) echo "</div>";
            ++$i;
            if($columns &&  $i==27){
                echo "</div><div class='row logos'><div class='medium-12 columns'><hr></div></div> <div class='row logos'>";
                $i = 0;
            }
            elseif($columns && (!($i%6))) echo "</div><div class='row logos'>";
            else {};
        }
    }
}
?>
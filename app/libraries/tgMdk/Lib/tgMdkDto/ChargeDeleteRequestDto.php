<?php
namespace App\libraries\tgMdk\Lib\tgMdkDto;
/**
 * 課金グループ削除要求リクエストDTO
 * @author Veritrans, Inc.
 */
class ChargeDeleteRequestDto extends AbstractPayNowIdRequestDto {

    public function __construct() {
        parent::__construct(PayNowIdConstants::SERVICE_TYPE_CHARGE, PayNowIdConstants::SERVICE_COMMAND_DELETE);
    }
}

?>
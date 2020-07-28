<?php

Namespace App\Libraries\tgMdk\Lib;

/**
 * 検索条件:Paypay検索パラメータクラス<br>
 *
 * @author Veritrans, Inc.
 *
 */
class PaypaySearchParameter
{

    /**
     * 詳細オーダー決済状態<br>
     */
    private $detailOrderType;

    /**
     * 詳細コマンドタイプ名<br>
     */
    private $detailCommandType;

    /**
     * paypayサービスタイプ<br>
     */
    private $paypayServiceType;

    /**
     * 詳細オーダー決済状態を取得する<br>
     *
     * @return string[] 詳細オーダー決済状態<br>
     */
    public function getDetailOrderType() {
        return $this->detailOrderType;
    }

    /**
     * 詳細オーダー決済状態を設定する<br>
     *
     * @param string[] $detailOrderType 詳細オーダー決済状態<br>
     */
    public function setDetailOrderType($detailOrderType) {
        $this->detailOrderType = $detailOrderType;
    }

    /**
     * 詳細コマンドタイプ名を取得する<br>
     *
     * @return string[] 詳細コマンドタイプ名<br>
     */
    public function getDetailCommandType() {
        return $this->detailCommandType;
    }

    /**
     * 詳細コマンドタイプ名を設定する<br>
     *
     * @param string[] $detailCommandType 詳細コマンドタイプ名<br>
     */
    public function setDetailCommandType($detailCommandType) {
        $this->detailCommandType = $detailCommandType;
    }

    /**
     * paypayサービスタイプを取得する<br>
     *
     * @return string[] paypayサービスタイプ<br>
     */
    public function getPaypayServiceType() {
        return $this->paypayServiceType;
    }

    /**
     * paypayサービスタイプを設定する<br>
     *
     * @param string[] $paypayServiceType paypayサービスタイプ<br>
     */
    public function setPaypayServiceType($paypayServiceType) {
        $this->paypayServiceType = $paypayServiceType;
    }

}
?>
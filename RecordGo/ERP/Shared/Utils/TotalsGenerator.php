<?php

namespace Shared\Utils;

use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Shared\Domain\Collection;

/**
 * Class TotalsGenerator
 * Para poder usar TotalsGenerator el satélite tiene que tener las clases Payment, PreRentalAgreement, RentalAgreement y SalesLine
 * De Payment necesitamos los métodos getPaymentPaytef, getPaymentAmount, getPreRentalAgreementId y getRentalAgreementId
 * De SalesLine necesitamos los métodos getTotalAmount, getUnitAmountTax, getPerCentDiscount y getQuantity
 */
class TotalsGenerator
{
    /**
     * @param Collection $paymentCollection
     * @param Collection $salesLineCollection
     * @param int $paymentMethodId
     * @param int $documentType
     * @param string|null $countryIso
     * @return array
     */
    public static function generateTotals(Collection $paymentCollection, Collection $salesLineCollection,int $paymentMethodId, int $documentType, ?string $countryIso = null):array {
        $amountPrePayed=0;
        $amountPrePayedBooking=0;
        $total=0;
        $totalFromDesk = 0;
        $totalAgency = 0;
        $outstandingAmount = 0;

        $isCREDIT = $paymentMethodId == intval(ConstantsJsonFile::getValue('PAYMENTMETHODS_CREDIT',$countryIso));
        $isAGENCY = $paymentMethodId == intval(ConstantsJsonFile::getValue('PAYMENTMETHODS_AGENCY',$countryIso));

        $isPRERA = $documentType == intval(ConstantsJsonFile::getValue('DOCUMENTTYPE_PRERA',$countryIso));
        $isRA = $documentType == intval(ConstantsJsonFile::getValue('DOCUMENTTYPE_RA',$countryIso));

        foreach ($paymentCollection as $payment) {
            $amount = $payment->getPaymentAmount();
            if($payment->getPaymentPaytef() !== null && $payment->getPaymentPaytef()->getAmountWithSign() !== null) {
                $sign = floatval(str_replace(',', '.', $payment->getPaymentPaytef()->getAmountWithSign()));
            } else {
                $sign = 1;
            }

            $amountPrePayed += ($sign < 0 ? -1 : 1) * abs($amount ?? 0);
            if ($payment->getPreRentalAgreementId() == null && $payment->getRentalAgreementId() == null) {
                $amountPrePayedBooking += ($sign < 0 ? -1 : 1) * abs($amount ?? 0);
            }
        }

        foreach ($salesLineCollection as $salesLine) {

            if($isCREDIT && !$salesLine->isBillToCustomer()) {
                continue;
            }

            $total += $salesLine->getTotalAmount() ??
                (($salesLine->getUnitAmountTax() - $salesLine->getUnitAmountTax() * $salesLine->getPerCentDiscount()) * $salesLine->getQuantity()) ?? 0;

            if($isAGENCY && $salesLine->isBillToCustomer()) {
                $totalAgency += $salesLine->getTotalAmount()??0;
            }

            // Hay que revisar en precontrato y contrato
            if($isPRERA && $salesLine->getBookingId() == null) {
                $totalFromDesk += $salesLine->getTotalAmount()??0;
            }
            if($isRA && $salesLine->getBookingId() == null && $salesLine->getPreRAId() == null) {
                $totalFromDesk += $salesLine->getTotalAmount()??0;
            }
        }

        if($isAGENCY) {
            $outstandingAmount = $totalAgency - $amountPrePayed;
        } else {
            $outstandingAmount = $total - $amountPrePayed;
        }

        return [
            'amountPrePayed' => round($amountPrePayed,2),
            'amountPrePayedBooking' =>  round($amountPrePayedBooking,2),
            'totalAmountTAX' =>  round($total,2),
            'outstandingAmount' =>  round($outstandingAmount,2),
            'totalAmountTAXSalesLineFromDesk' =>  round($totalFromDesk,2)
        ];
    }

    public static function fixLines(array &$salesLinesOrig, int $paymentMethodId, ?string $countryIso = null): array
    {
        $isCREDIT = $paymentMethodId == intval(ConstantsJsonFile::getValue('PAYMENTMETHODS_CREDIT',$countryIso));

        foreach ($salesLinesOrig as &$line) {

            if($isCREDIT && !$line['billToCustomer']) {
                continue;
            }

            if(is_null($line['perCentDiscount'])){
                $line['perCentDiscount'] = 0.0;
            }
            if(is_null($line['totalUnitAmount'])){
                $line['totalAmount'] = ($line['unitAmountTax'] - $line['unitAmountTax'] * $line['perCentDiscount']) * $line['quantity'];
                $line['totalUnitAmount'] = $line['unitAmountTax'] - $line['unitAmountTax'] * $line['perCentDiscount'];
                $line['formatedAmount'] = 1;
            }
        }

        unset($line);
        return $salesLinesOrig;
    }
}
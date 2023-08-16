<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * Class AccountItem
 *
 * @package App\Models
 * @property string $name
 * @property boolean $is_active
 * @property int $id
 * @property string $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem active()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountItem whereUpdatedAt($value)
 */
	class AccountItem extends \Eloquent {}
}

namespace App\Models\Accounting{
/**
 * App\Models\Accounting\Journal
 *
 * @property int $id
 * @property string $type
 * @property string $code
 * @property string|null $name_ar
 * @property string $name_en
 * @property string|null $description
 * @property int $is_housemaid_financial
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Journal active()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Journal where($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereIsHousemaidFinancial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Journal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Journal extends \Eloquent {}
}

namespace App\Models\Accounting{
/**
 * App\Models\Accounting\Transaction
 *
 * @property int $id
 * @property string $status
 * @property string $payment_solutions
 * @property int|null $external_office_id
 * @property float|null $send_dollar
 * @property string|null $deliver_date
 * @property string|null $from_bank_account
 * @property string|null $ref_payment
 * @property float|null $rate_on_dollar
 * @property float|null $total_local_currency
 * @property float|null $fess
 * @property float|null $total_in_kwd
 * @property string|null $references_files
 * @property float $balance_external_office
 * @property int|null $sponsor_id
 * @property float|null $price_in_kwd
 * @property int|null $application_id
 * @property string|null $payment_type
 * @property string|null $recipient
 * @property float|null $amount
 * @property float|null $paid_payment
 * @property float|null $discount_amount
 * @property float|null $due
 * @property string|null $note
 * @property string|null $application_code
 * @property float|null $amount_commission
 * @property int|null $internal_office_id
 * @property string|null $to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application|null $application
 * @property-read \App\Models\ExternalOffice|null $externalOffice
 * @property-read \App\Models\InternalOffice|null $internalOffice
 * @property-read \App\Models\Sponsor|null $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmountCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereApplicationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBalanceExternalOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeliverDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereExternalOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFromBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereInternalOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePaidPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePaymentSolutions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePriceInKwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereRateOnDollar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereRecipient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereRefPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereReferencesFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSendDollar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTotalInKwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTotalLocalCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Application
 *
 * @package App\Models
 * @property string $code
 * @property string $name_en
 * @property string $name_ar
 * @property string $address_en
 * @property string $address_ar
 * @property integer $age
 * @property string $birth_date
 * @property string $gender
 * @property string $marital_status
 * @property integer $kids_no
 * @property string $photo
 * @property string $full_body_photo
 * @property double $housemaid_price
 * @property double $salary
 * @property double $office_commission
 * @property integer $currency_id
 * @property integer $external_office_id
 * @property integer $internal_office_id
 * @property integer $sponsor_id
 * @property string $passport_no
 * @property string $passport_issue_date
 * @property string $passport_expiry_date
 * @property string $place_birth
 * @property integer $country_id
 * @property string $english_skills
 * @property string $arabic_skills
 * @property string $experience
 * @property string $experience_details
 * @property integer $job_id
 * @property integer $religion_id
 * @property integer $education_id
 * @property integer $created_by_id
 * @property integer $responsible_user_id
 * @property int $id
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ApplicationStatus\ApplicationArrival|null $arrival
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\User|null $created_by
 * @property-read \App\Models\Currency|null $currency
 * @property-read \App\Models\ApplicationStatus\ApplicationDeliver|null $deliver
 * @property-read \App\Models\ApplicationStatus\ApplicationDeportation|null $deportation
 * @property-read \App\Models\Education|null $education
 * @property-read \App\Models\ApplicationStatus\ApplicationExpectedArrival|null $expectedArrival
 * @property-read \App\Models\ExternalOffice|null $external_office
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExternalOfficeTransaction[] $external_office_transactions
 * @property-read int|null $external_office_transactions_count
 * @property-read \App\Models\InternalOffice|null $internal_office
 * @property-read \App\Models\Job|null $job
 * @property-read \Illuminate\Database\Eloquent\Collection|\Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition[] $pendingTransitions
 * @property-read int|null $pending_transitions_count
 * @property-read \App\Models\Religion|null $religion
 * @property-read \App\Models\ApplicationStatus\ApplicationResell|null $resell
 * @property-read \App\Models\ApplicationStatus\ApplicationReservation|null $reservation
 * @property-read \App\Models\User|null $responsible_user
 * @property-read \App\Models\Sponsor|null $sponsor
 * @property-read \Illuminate\Database\Eloquent\Collection|\Asantibanez\LaravelEloquentStateMachines\Models\StateHistory[] $stateHistory
 * @property-read int|null $state_history_count
 * @property-read \App\Models\ApplicationStatus\ApplicationVisa|null $visa
 * @method static \Illuminate\Database\Eloquent\Builder|Application active()
 * @method static \Illuminate\Database\Eloquent\Builder|Application filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAddressAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAddressEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereArabicSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereEducationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereEnglishSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereExperienceDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereExternalOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereFullBodyPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereHousemaidPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereInternalOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereKidsNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereOfficeCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePassportExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePassportIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePassportNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePlaceBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereReligionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereResponsibleUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class Application extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ApplicationExternalOfficeTransaction
 *
 * @package App\Models
 * @property int $id
 * @property string|null $note
 * @property string|null $date
 * @property int $application_id
 * @property int|null $external_office_transaction_id
 * @property int|null $created_by_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application $application
 * @property-read \App\Models\ExternalOfficeTransaction|null $external_office_transaction
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction whereExternalOfficeTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExternalOfficeTransaction whereUpdatedAt($value)
 */
	class ApplicationExternalOfficeTransaction extends \Eloquent {}
}

namespace App\Models\ApplicationStatus{
/**
 * App\Models\ApplicationStatus\ApplicationArrival
 *
 * @property int $id
 * @property string $flight_no
 * @property string $flight_agent_name
 * @property string $transaction_date
 * @property string $arrival_date
 * @property string $application_email_date
 * @property string|null $note
 * @property bool $status
 * @property string|null $cancellation_date
 * @property int|null $created_by_id
 * @property int $application_id
 * @property int|null $sponsor_id
 * @property string $created_at
 * @property string $updated_at
 * @property-read \App\Models\Application $application
 * @property-read \App\Models\User|null $created_by
 * @property-read \App\Models\Sponsor|null $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival active()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereApplicationEmailDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereArrivalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereCancellationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereFlightAgentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereFlightNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationArrival whereUpdatedAt($value)
 */
	class ApplicationArrival extends \Eloquent {}
}

namespace App\Models\ApplicationStatus{
/**
 * App\Models\ApplicationStatus\ApplicationDeliver
 *
 * @property int $id
 * @property string $transaction_date
 * @property string $deliver_date
 * @property int|null $invoice
 * @property string $pay_status
 * @property float $paid_amount
 * @property float $discount_amount
 * @property float $total
 * @property float $due
 * @property string|null $note
 * @property string|null $cancellation_date
 * @property bool $status
 * @property int $application_id
 * @property int|null $created_by_id
 * @property int|null $sponsor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application $application
 * @property-read \App\Models\User|null $created_by
 * @property-read mixed $photo
 * @property-read \App\Models\Sponsor|null $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver active()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereCancellationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereDeliverDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeliver whereUpdatedAt($value)
 */
	class ApplicationDeliver extends \Eloquent {}
}

namespace App\Models\ApplicationStatus{
/**
 * App\Models\ApplicationStatus\ApplicationDeportation
 *
 * @property int $id
 * @property string $transaction_date
 * @property string $arrival_date
 * @property string $application_email_date
 * @property string $flight_no
 * @property string $flight_agent_name
 * @property string $reason
 * @property int $days
 * @property string|null $note
 * @property bool $status
 * @property string|null $cancellation_date
 * @property int|null $created_by_id
 * @property int $application_id
 * @property int|null $sponsor_id
 * @property string $created_at
 * @property string $updated_at
 * @property-read \App\Models\Application $application
 * @property-read \App\Models\User|null $created_by
 * @property-read \App\Models\Sponsor|null $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation active()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereApplicationEmailDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereArrivalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereCancellationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereFlightAgentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereFlightNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDeportation whereUpdatedAt($value)
 */
	class ApplicationDeportation extends \Eloquent {}
}

namespace App\Models\ApplicationStatus{
/**
 * App\Models\ApplicationStatus\ApplicationExpectedArrival
 *
 * @property int $id
 * @property string $flight_no
 * @property string $flight_agent_name
 * @property string $transaction_date
 * @property string $expected_arrival_time
 * @property string $application_email_date
 * @property string|null $photo
 * @property string|null $note
 * @property int|null $created_by_id
 * @property int $application_id
 * @property bool $status
 * @property string|null $cancellation_date
 * @property int|null $sponsor_id
 * @property string $created_at
 * @property string $updated_at
 * @property-read \App\Models\Application $application
 * @property-read \App\Models\User|null $created_by
 * @property-read \App\Models\Sponsor|null $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival active()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereApplicationEmailDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereCancellationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereExpectedArrivalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereFlightAgentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereFlightNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationExpectedArrival whereUpdatedAt($value)
 */
	class ApplicationExpectedArrival extends \Eloquent {}
}

namespace App\Models\ApplicationStatus{
/**
 * App\Models\ApplicationStatus\ApplicationResell
 *
 * @property int $id
 * @property string $resell_date
 * @property float $sponsor_refund
 * @property bool $paid_to_sponsor
 * @property int $invoice_id
 * @property string $invoice_status
 * @property float $invoice_amount
 * @property float $invoice_due_amount
 * @property string|null $note
 * @property string|null $cancellation_date
 * @property bool $status
 * @property int $application_id
 * @property int|null $created_by_id
 * @property int|null $sponsor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application $application
 * @property-read \App\Models\User|null $created_by
 * @property-read mixed $photo
 * @property-read \App\Models\Sponsor|null $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell active()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereCancellationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereInvoiceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereInvoiceDueAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell wherePaidToSponsor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereResellDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereSponsorRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationResell whereUpdatedAt($value)
 */
	class ApplicationResell extends \Eloquent {}
}

namespace App\Models\ApplicationStatus{
/**
 * Class ApplicationReservation
 *
 * @package App\Models
 * @property string $passport_id
 * @property integer $reservation_days
 * @property string $reservation_date
 * @property string $pay_due_date
 * @property double $deal_amount
 * @property double $down_payment_amount
 * @property boolean $paid_immediately
 * @property boolean $status
 * @property integer $application_id
 * @property integer $sponsor_id
 * @property integer $invoice_sales_id
 * @property integer $created_by_id
 * @property int $id
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application $application
 * @property-read \App\Models\User|null $created_by
 * @property-read mixed $cancellation_date
 * @property-read \App\Models\Sponsor|null $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation active()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereDealAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereDownPaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereInvoiceSalesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation wherePaidImmediately($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation wherePassportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation wherePayDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereReservationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereReservationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationReservation whereUpdatedAt($value)
 */
	class ApplicationReservation extends \Eloquent {}
}

namespace App\Models\ApplicationStatus{
/**
 * Class ApplicationVisa
 *
 * @package App\Models
 * @property string $transaction_date
 * @property string $passport_id
 * @property string $unified_no
 * @property integer $visa_issue_days
 * @property integer $visa_received_days
 * @property string $visa_no
 * @property string $photo
 * @property string $visa_issue_date
 * @property string $visa_expiry_date
 * @property string $visa_received_date
 * @property string $visa_send_date
 * @property string $note
 * @property string $cancellation_date
 * @property boolean $status
 * @property integer $application_id
 * @property integer $sponsor_id
 * @property integer $created_by_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application $application
 * @property-read \App\Models\User|null $created_by
 * @property-read \App\Models\Sponsor|null $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa active()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereCancellationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa wherePassportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereUnifiedNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereVisaExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereVisaIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereVisaIssueDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereVisaNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereVisaReceivedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereVisaReceivedDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationVisa whereVisaSendDate($value)
 */
	class ApplicationVisa extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Country
 *
 * @package App\Models
 * @property string $name_en
 * @property string $name_ar
 * @property string $code
 * @property string $link
 * @property boolean $is_active
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Country active()
 * @method static \Illuminate\Database\Eloquent\Builder|Country filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Currency
 *
 * @package App\Models
 * @property string $name_en
 * @property string $name_ar
 * @property string $symbol
 * @property string $unit
 * @property string $sub_unit
 * @property string $rate
 * @property boolean $is_active
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Currency active()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereSubUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Education
 *
 * @package App\Models
 * @property string $name
 * @property boolean $is_active
 * @property int $id
 * @property string $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Education active()
 * @method static \Illuminate\Database\Eloquent\Builder|Education filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Education newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Education newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Education query()
 * @method static \Illuminate\Database\Eloquent\Builder|Education sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Education withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class Education extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ExternalOffice
 *
 * @package App\Models
 * @property string $name_en
 * @property string $name_ar
 * @property string $address_en
 * @property string $address_ar
 * @property string $code
 * @property string $phone
 * @property double $commission
 * @property integer $country_id
 * @property integer $currency_id
 * @property boolean $is_active
 * @method static find(mixed $external_office_id)
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $bank_info_name
 * @property string|null $bank_info_company_name
 * @property string|null $bank_info_beneficiary_name
 * @property string|null $bank_info_swift_code
 * @property string|null $bank_info_iban
 * @property string|null $bank_info_account_number
 * @property string|null $bank_info_phone
 * @property int|null $bank_info_country_id
 * @property int|null $bank_info_currency_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $applications
 * @property-read int|null $applications_count
 * @property-read \App\Models\Country|null $bank_info_country
 * @property-read \App\Models\Currency|null $bank_info_currency
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InternalOffice[] $internal_offices
 * @property-read int|null $internal_offices_count
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice active()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereAddressAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereAddressEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereBankInfoAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereBankInfoBeneficiaryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereBankInfoCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereBankInfoCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereBankInfoCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereBankInfoIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereBankInfoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereBankInfoPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereBankInfoSwiftCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOffice withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class ExternalOffice extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ExternalOfficeTransaction
 *
 * @package App\Models
 * @property string $name
 * @property boolean $is_active
 * @property int $id
 * @property string $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $applications
 * @property-read int|null $applications_count
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction active()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalOfficeTransaction withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class ExternalOfficeTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * Class InternalOffice
 *
 * @package App\Models
 * @property string $name_en
 * @property string $name_ar
 * @property string $address_en
 * @property string $address_ar
 * @property string $code
 * @property string $phone
 * @property string $registration_number
 * @property boolean $is_active
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $num_ministry_commerce
 * @property string|null $manpower
 * @property int|null $country_id
 * @property int|null $currency_id
 * @property string|null $bank_info_name
 * @property string|null $bank_info_company_name
 * @property string|null $bank_info_beneficiary_name
 * @property string|null $bank_info_swift_code
 * @property string|null $bank_info_iban
 * @property string|null $bank_info_account_number
 * @property string|null $bank_info_phone
 * @property int|null $bank_info_country_id
 * @property int|null $bank_info_currency_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $applications
 * @property-read int|null $applications_count
 * @property-read \App\Models\Country|null $bank_info_country
 * @property-read \App\Models\Currency|null $bank_info_currency
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExternalOffice[] $external_offices
 * @property-read int|null $external_offices_count
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice active()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereAddressAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereAddressEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereBankInfoAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereBankInfoBeneficiaryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereBankInfoCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereBankInfoCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereBankInfoCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereBankInfoIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereBankInfoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereBankInfoPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereBankInfoSwiftCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereManpower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereNumMinistryCommerce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalOffice withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class InternalOffice extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Job
 *
 * @package App\Models
 * @property string $name_en
 * @property string $name_ar
 * @property boolean $is_active
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Job active()
 * @method static \Illuminate\Database\Eloquent\Builder|Job filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|Job sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class Job extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Language
 *
 * @package App\Models
 * @property string $name_en
 * @property string $name_ar
 * @property string $code
 * @property string $link
 * @property boolean $is_active
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Language active()
 * @method static \Illuminate\Database\Eloquent\Builder|Language filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class Language extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Religion
 *
 * @package App\Models
 * @property string $name
 * @property boolean $is_active
 * @property int $id
 * @property string $name_en
 * @property string|null $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Religion active()
 * @method static \Illuminate\Database\Eloquent\Builder|Religion filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Religion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Religion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Religion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Religion sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Religion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Religion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Religion whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Religion whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Religion whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Religion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Religion withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class Religion extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Sponsor
 *
 * @package App\Models
 * @property string $name_en
 * @property string $name_ar
 * @property string $address_en
 * @property string $address_ar
 * @property string $civil_id
 * @property string $email
 * @property string $mobile
 * @property string $phone
 * @property string $password
 * @property string $link
 * @property boolean $is_block
 * @property boolean $is_active
 * @property int $id
 * @property string|null $language
 * @property string|null $gender
 * @property string|null $photo
 * @property string|null $front_civil_photo
 * @property string|null $device_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property int|null $country_id
 * @property int|null $job_id
 * @property int|null $created_by_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $back_civil_photo
 * @property string|null $blood_type
 * @property string|null $expire_date_civil_card
 * @property string|null $birth_date
 * @property string|null $unit_type
 * @property string|null $area
 * @property string|null $block
 * @property string|null $street
 * @property string|null $unit_no
 * @property string|null $floor
 * @property string|null $building_no
 * @property string|null $serial_no
 * @property string|null $paci_unit_no
 * @property string|null $shipping_email
 * @property mixed|null $phones
 * @property string|null $job_position
 * @property string|null $work_attachments
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\Job|null $job
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor active()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor blocked()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereAddressAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereAddressEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereBackCivilPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereBuildingNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereCivilId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereDeviceToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereExpireDateCivilCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereFrontCivilPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereIsBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereJobPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor wherePaciUnitNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor wherePhones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereSerialNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereShippingEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereUnitNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor whereWorkAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sponsor withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class Sponsor extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $photo
 * @property string|null $device_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $mobile
 * @property string $type
 * @property string $role
 * @property int|null $model_id
 * @property string|null $model_type
 * @property mixed|null $all_permissions
 * @property mixed|null $current_permissions
 * @property string|null $signature
 * @property int|null $language_id
 * @property int|null $country_id
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\Language|null $language
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter($input = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User sorted($query = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAllPermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentPermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeviceToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withFilter(\LaravelLegends\EloquentFilter\Filters\ModelFilter $filter, $input = null)
 */
	class User extends \Eloquent {}
}


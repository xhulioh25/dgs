<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Duhet pranuar :attribute.',
    'active_url'           => ':attribute nuk eshte nje URL e vlefshme.',
    'after'                => ':attribute duhet te jete pas dates :date.',
    'alpha'                => ':attribute mund te permbaje vetem shkronja.',
    'alpha_dash'           => ':attribute mund te permbaje vetem shkronja, numra dhe vija.',
    'alpha_num'            => ':attribute mund te permbaje vetem shkronja dhe numra.',
    'array'                => ':attribute duhet te jete nje liste.',
    'before'               => ':attribute duhet te jete para dates :date.',
    'between'              => [
        'numeric' => ':attribute duhet te jete mes :min dhe :max.',
        'file'    => ':attribute duhet te jete te pakten :min dhe jo me shume se :max kilobytes.',
        'string'  => ':attribute duhet te permbaje te pakten :min dhe jo me shume se :max karaktere.',
        'array'   => ':attribute duhet te permbaje te pakten :min dje jo me shume se :max items.',
    ],
    'boolean'              => ':attribute duhet te jete "E vertete" ose "E gabuar".',
    'confirmed'            => 'Fjalekalimet nuk perputhen.',
    'date'                 => ':attribute nuk eshte nje date e vlefshmee.',
    'date_format'          => ':attribute nuk perputhet me formatin :format.',
    'different'            => ':attribute dhe :other duhet te jene te ndryshem.',
    'digits'               => ':attribute duhet te kete :digits karaktere.',
    'digits_between'       => ':attribute duhet te kete te pakten :min dhe jo me shume se :max karaktere.',
    'email'                => ':attribute duhet te jete nje adrese e-mail e vlafshme.',
    'filled'               => ':attribute duhet te plotesohet.',
    'exists'               => ':attribute i zgjedhur eshte i pavlefshem.',
    'image'                => ':attribute duhet te jete nje imazh.',
    'in'                   => ':attribute i zgjedhur eshte i pavlefshem.',
    'integer'              => ':attribute duhet te jete nje numer.',
    'ip'                   => ':attribute duhet te jete nje adrese IP e vlefshme.',
    'max'                  => [
        'numeric' => ':attribute nuk duhet te jete me i madh se :max.',
        'file'    => ':attribute nuk duhet te tejkaloje limitin prej :max kilobytes.',
        'string'  => ':attribute nuk duhet te tejkaloje limitin prej :max kalakteresh.',
        'array'   => ':attribute nuk duhet te tejkaloje limitin prej :max elementesh.',
    ],
    'mimes'                => ':attribute duhet te jete e formatit: :values.',
    'min'                  => [
        'numeric' => ':attribute duhet te jete te pakten :min.',
        'file'    => ':attribute duhet te jete te pakten :min kilobytes.',
        'string'  => ':attribute duhet te permbaje te pakten :min karaktere.',
        'array'   => ':attribute duhet te permbaje te pakten :min elemente.',
    ],
    'not_in'               => ':attribute i zgjedhur eshte i pavlefshem.',
    'numeric'              => ':attribute duhet te jete nje numer.',
    'regex'                => ':attribute ka format te pavlefshem.',
    'required'             => ':attribute duhet te plotesohet.',
    'required_if'          => ':attribute duhet te plotesohet kur :other eshte :value.',
    'required_with'        => ':attribute duhet te plotesohet kur :values jane plotesuar.',
    'required_with_all'    => ':attribute duhet te plotesohet kur :values jane plotesuar.',
    'required_without'     => ':attribute duhet te plotesohet kur :values nuk jane plotesuar.',
    'required_without_all' => ':attribute duhet te plotesohet kur asnjera prej :values nuk jane plotesuar.',
    'same'                 => ':attribute duhet te perputhet me :other.',
    'size'                 => [
        'numeric' => ':attribute duhet te jete :size.',
        'file'    => ':attribute duhet te jete :size kilobytes.',
        'string'  => ':attribute duhet te jete :size karaktere.',
        'array'   => ':attribute duhet te permbaje :size elemente.',
    ],
    'string'               => ':attribute duhet te jete tekst.',
    'unique'               => ':attribute nuk eshte i disponueshem.',
    'url'                  => ':attribute ka format te pavlefshem.',
    'timezone'             => ':attribute duhet te jete nje zone kohore e vlefshme.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

<?php

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
        'accepted' => 'يجب قبول حقل :attribute.',
        'accepted_if' => 'يجب قبول حقل :attribute عندما يكون :other هو :value.',
        'active_url' => 'يجب أن يكون حقل :attribute عنوان URL صالحًا.',
        'after' => 'يجب أن يكون حقل :attribute تاريخًا بعد :date.',
        'after_or_equal' => 'يجب أن يكون حقل :attribute تاريخًا بعد أو يساوي :date.',
        'alpha' => 'يجب أن يحتوي حقل :attribute على أحرف فقط.',
        'alpha_dash' => 'يجب أن يحتوي حقل :attribute على أحرف وأرقام وشرطات وشرطات سفلية فقط.',
        'alpha_num' => 'يجب أن يحتوي حقل :attribute على أحرف وأرقام فقط.',
        'array' => 'يجب أن يكون حقل :attribute مصفوفة.',
        'ascii' => 'يجب أن يحتوي حقل :attribute على أحرف أبجدية أحادية بايت ورموز فقط.',
        'before' => 'يجب أن يكون حقل :attribute تاريخًا قبل :date.',
        'before_or_equal' => 'يجب أن يكون حقل :attribute تاريخًا قبل أو يساوي :date.',
        'between' => [
            'array' => 'يجب أن يحتوي حقل :attribute على بين :min و :max عناصر.',
            'file' => 'يجب أن يكون حجم حقل :attribute بين :min و :max كيلوبايت.',
            'numeric' => 'يجب أن يكون حقل :attribute بين :min و :max.',
            'string' => 'يجب أن يكون حقل :attribute بين :min و :max حرفًا.',
        ],
        'boolean' => 'يجب أن يكون حقل :attribute صحيحًا أو خاطئًا.',
        'can' => 'يحتوي حقل :attribute على قيمة غير مصرح بها.',
        'confirmed' => 'حقل :attribute التأكيد غير مطابق.',
        'contains' => 'يفتقد حقل :attribute قيمة مطلوبة.',
        'current_password' => 'كلمة المرور غير صحيحة.',
        'date' => 'يجب أن يكون حقل :attribute تاريخًا صالحًا.',
        'date_equals' => 'يجب أن يكون حقل :attribute تاريخًا يساوي :date.',
        'date_format' => 'يجب أن يتطابق حقل :attribute مع الشكل :format.',
        'decimal' => 'يجب أن يحتوي حقل :attribute على :decimal أماكن عشرية.',
        'declined' => 'يجب رفض حقل :attribute.',
        'declined_if' => 'يجب رفض حقل :attribute عندما يكون :other هو :value.',
        'different' => 'يجب أن يكون حقل :attribute مختلفًا عن :other.',
        'digits' => 'يجب أن يكون حقل :attribute :digits أرقام.',
        'digits_between' => 'يجب أن يكون حقل :attribute بين :min و :max أرقام.',
        'dimensions' => 'حقل :attribute يحتوي على أبعاد صورة غير صالحة.',
        'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
        'doesnt_end_with' => 'يجب ألا ينتهي حقل :attribute بأحد القيم التالية: :values.',
        'doesnt_start_with' => 'يجب ألا يبدأ حقل :attribute بأحد القيم التالية: :values.',
        'email' => 'يجب أن يكون حقل :attribute عنوان بريد إلكتروني صالح.',
        'ends_with' => 'يجب أن ينتهي حقل :attribute بأحد القيم التالية: :values.',
        'enum' => 'القيمة المحددة :attribute غير صالحة.',
        'exists' => ':attribute غير صالح.',
        'extensions' => 'يجب أن يحتوي حقل :attribute على إحدى الامتدادات التالية: :values.',
        'file' => 'يجب أن يكون حقل :attribute ملفًا.',
        'filled' => 'يجب أن يحتوي حقل :attribute على قيمة.',
        'gt' => [
            'array' => 'يجب أن يحتوي حقل :attribute على أكثر من :value عناصر.',
            'file' => 'يجب أن يكون حجم حقل :attribute أكبر من :value كيلوبايت.',
            'numeric' => 'يجب أن يكون حقل :attribute أكبر من :value.',
            'string' => 'يجب أن يكون حقل :attribute أكبر من :value حرفًا.',
        ],
        'gte' => [
            'array' => 'يجب أن يحتوي حقل :attribute على :value عنصر أو أكثر.',
            'file' => 'يجب أن يكون حجم حقل :attribute أكبر من أو يساوي :value كيلوبايت.',
            'numeric' => 'يجب أن يكون حقل :attribute أكبر من أو يساوي :value.',
            'string' => 'يجب أن يكون حقل :attribute أكبر من أو يساوي :value حرفًا.',
        ],
        'hex_color' => 'يجب أن يكون حقل :attribute لونًا سداسي عشري صالحًا.',
        'image' => 'يجب أن يكون حقل :attribute صورة.',
        'in' => ':attribute غير صالح.',
        'in_array' => 'يجب أن يكون حقل :attribute موجودًا في :other.',
        'integer' => 'يجب أن يكون حقل :attribute عددًا صحيحًا.',
        'ip' => 'يجب أن يكون حقل :attribute عنوان IP صالحًا.',
        'ipv4' => 'يجب أن يكون حقل :attribute عنوان IPv4 صالحًا.',
        'ipv6' => 'يجب أن يكون حقل :attribute عنوان IPv6 صالحًا.',
        'json' => 'يجب أن يكون حقل :attribute سلسلة JSON صالحة.',
        'list' => 'يجب أن يكون حقل :attribute قائمة.',
        'lowercase' => 'يجب أن يكون حقل :attribute حروفًا صغيرة.',
        'lt' => [
            'array' => 'يجب أن يحتوي حقل :attribute على أقل من :value عناصر.',
            'file' => 'يجب أن يكون حجم حقل :attribute أقل من :value كيلوبايت.',
            'numeric' => 'يجب أن يكون حقل :attribute أقل من :value.',
            'string' => 'يجب أن يكون حقل :attribute أقل من :value حرفًا.',
        ],
        'lte' => [
            'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :value عنصر.',
            'file' => 'يجب أن يكون حجم حقل :attribute أقل من أو يساوي :value كيلوبايت.',
            'numeric' => 'يجب أن يكون حقل :attribute أقل من أو يساوي :value.',
            'string' => 'يجب أن يكون حقل :attribute أقل من أو يساوي :value حرفًا.',
        ],
        'mac_address' => 'يجب أن يكون حقل :attribute عنوان MAC صالحًا.',
        'max' => [
            'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max عنصر.',
            'file' => 'يجب ألا يكون حجم حقل :attribute أكبر من :max كيلوبايت.',
            'numeric' => 'يجب ألا يكون حقل :attribute أكبر من :max.',
            'string' => 'يجب ألا يكون حقل :attribute أكبر من :max حرفًا.',
        ],
        'max_digits' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max أرقام.',
        'mimes' => 'يجب أن يكون حقل :attribute ملفًا من النوع: :values.',
        'mimetypes' => 'يجب أن يكون حقل :attribute ملفًا من النوع: :values.',
        'min' => [
            'array' => 'يجب أن يحتوي حقل :attribute على الأقل على :min عنصر.',
            'file' => 'يجب أن يكون حجم حقل :attribute على الأقل :min كيلوبايت.',
            'numeric' => 'يجب أن يكون حقل :attribute على الأقل :min.',
            'string' => 'يجب أن يكون حقل :attribute على الأقل :min حرفًا.',
        ],
        'min_digits' => 'يجب أن يحتوي حقل :attribute على الأقل على :min أرقام.',
        'missing' => 'يجب أن يكون حقل :attribute مفقودًا.',
        'missing_if' => 'يجب أن يكون حقل :attribute مفقودًا عندما يكون :other هو :value.',
        'missing_unless' => 'يجب أن يكون حقل :attribute مفقودًا ما لم يكن :other هو :value.',
        'missing_with' => 'يجب أن يكون حقل :attribute مفقودًا عندما يكون :values موجودًا.',
        'missing_with_all' => 'يجب أن يكون حقل :attribute مفقودًا عندما تكون :values موجودة.',
        'multiple_of' => 'يجب أن يكون حقل :attribute مضاعفًا لـ :value.',
        'not_in' => 'القيمة المحددة :attribute غير صالحة.',
        'not_regex' => 'تنسيق حقل :attribute غير صالح.',
        'numeric' => 'يجب أن يكون حقل :attribute رقمًا.',
        'password' => [
            'letters' => 'يجب أن يحتوي حقل :attribute على حرف واحد على الأقل.',
            'mixed' => 'يجب أن يحتوي حقل :attribute على حرف واحد على الأقل من الحروف الكبيرة والحروف الصغيرة.',
            'numbers' => 'يجب أن يحتوي حقل :attribute على رقم واحد على الأقل.',
            'symbols' => 'يجب أن يحتوي حقل :attribute على رمز واحد على الأقل.',
            'uncompromised' => 'تم ظهور :attribute المعطى في تسريب بيانات. يرجى اختيار :attribute مختلف.',
        ],
        'present' => 'يجب أن يكون حقل :attribute موجودًا.',
        'present_if' => 'يجب أن يكون حقل :attribute موجودًا عندما يكون :other هو :value.',
        'present_unless' => 'يجب أن يكون حقل :attribute موجودًا ما لم يكن :other هو :value.',
        'present_with' => 'يجب أن يكون حقل :attribute موجودًا عندما يكون :values موجودًا.',
        'present_with_all' => 'يجب أن يكون حقل :attribute موجودًا عندما تكون :values موجودة.',
        'prohibited' => 'حقل :attribute محظور.',
        'prohibited_if' => 'حقل :attribute محظور عندما يكون :other هو :value.',
        'prohibited_unless' => 'حقل :attribute محظور ما لم يكن :other موجودًا في :values.',
        'prohibits' => 'حقل :attribute يمنع وجود :other.',
        'regex' => 'تنسيق حقل :attribute غير صالح.',
        'required' => 'حقل :attribute مطلوب.',
        'required_array_keys' => 'يجب أن يحتوي حقل :attribute على إدخالات لـ: :values.',
        'required_if' => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
        'required_if_accepted' => 'حقل :attribute مطلوب عندما يتم قبول :other.',
        'required_if_declined' => 'حقل :attribute مطلوب عندما يتم رفض :other.',
        'required_unless' => 'حقل :attribute مطلوب ما لم يكن :other موجودًا في :values.',
        'required_with' => 'حقل :attribute مطلوب عندما يكون :values موجودًا.',
        'required_with_all' => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
        'required_without' => 'حقل :attribute مطلوب عندما لا يكون :values موجودًا.',
        'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
        'same' => 'يجب أن يتطابق حقل :attribute مع :other.',
        'size' => [
            'array' => 'يجب أن يحتوي حقل :attribute على :size عنصرًا.',
        'file' => 'يجب أن يكون حقل :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن يكون حقل :attribute :size.',
        'string' => 'يجب أن يكون حقل :attribute :size أحرف.',
        ],
        'starts_with' => 'يجب أن يبدأ حقل :attribute بأحد القيم التالية: :values.',
        'string' => 'يجب أن يكون حقل :attribute سلسلة نصية.',
        'timezone' => 'يجب أن يكون حقل :attribute منطقة زمنية صالحة.',
        'unique' => 'تم استخدام :attribute مسبقًا.',
        'uploaded' => 'فشل تحميل :attribute.',
        'uppercase' => 'يجب أن يكون حقل :attribute حروف كبيرة.',
        'url' => 'يجب أن يكون حقل :attribute عنوان URL صالح.',
        'ulid' => 'يجب أن يكون حقل :attribute ULID صالح.',
        'uuid' => 'يجب أن يكون حقل :attribute UUID صالح.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'name' => 'الاسم',
        'first_name' => 'الاسم الأول',
        'last_name' => 'الاسم الأخير',
        'current_password' => 'كلمة المرور الحالية',
        'new_password' => 'كلمة المرور الجديدة',
        'new_password_confirmation' => 'تأكيد كلمة المرور الجديدة',
        'api_id' => 'رقم اللاعب',
        'season_id' => 'الموسم',
        'country_id' => 'الدولة',
        'price' => 'السعر',
        'name_in_match' => 'الاسم في المباراة',
        't_shirt' => 'القميص',
        'position' => 'المركز',
        'player_status' => 'حالة اللاعب',
        'current_club_id' => 'النادي الحالي',
        'status' => 'الحالة',
        'national_team_id' => 'المنتخب الوطني',
        'reason' => 'السبب',
        'file' => 'الملف',
        'file.*' => 'الملف',
        'phone' => 'رقم الهاتف',
        'subscribe_news' => 'الاشتراك في النشرة الإخبارية',
        'player_id' => 'اللاعب',
        'club_id' => 'النادي',
        'type' => 'النوع',
        'league_id' => 'الدوري',
        'member_id' => 'العضو',
        'code' => 'الكود',
        'image' => 'الصورة',
        'per_page' => 'عدد العناصر في الصفحة',
    ],

];

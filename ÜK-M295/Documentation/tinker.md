󰪥 php artisan tinker                                                                          
Psy Shell v0.12.8 (PHP 8.4.0 — cli) by Justin Hileman                                         
> DB::connection()->getPdo()                                                                  
= Pdo\Sqlite {#5231                                                                           
    inTransaction: false,
    attributes: {
      CASE: NATURAL,
      ERRMODE: EXCEPTION,
      PERSISTENT: false,
      DRIVER_NAME: "sqlite",
      ORACLE_NULLS: NATURAL,
      CLIENT_VERSION: "3.43.2",
      SERVER_VERSION: "3.43.2",
      STATEMENT_CLASS: [
        "PDOStatement",
      ],
      STRINGIFY_FETCHES: false,
      DEFAULT_FETCH_MODE: BOTH,
    },
  }

> DB::table('users')->get()
= Illuminate\Support\Collection {#5249
    all: [
      {#5244
        +"id": 1,
        +"name": "DB_user",
        +"email": "user@example.com",
      },
    ],
  }

> DB::table('users')->count()
= 1

>
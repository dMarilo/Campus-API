<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [

            // Core Electrical Engineering
            [
                'title' => 'Osnovi Elektrotehnike 1',
                'author' => 'Milan Petrović',
                'isbn' => '9788651230011',
                'publisher' => 'ETF Istočno Sarajevo',
                'published_year' => 2016,
                'edition' => '2',
                'description' => 'Uvod u elektrotehniku: otpornici, kola, Kirhofovi zakoni, analiza strujnih krugova.',
                'total_copies' => 5,
                'available_copies' => 5,
                'cover_image_url' => null
            ],
            [
                'title' => 'Osnovi Elektrotehnike 2',
                'author' => 'Milan Petrović',
                'isbn' => '9788651230012',
                'publisher' => 'ETF Istočno Sarajevo',
                'published_year' => 2018,
                'edition' => '1',
                'description' => 'Naizmenične struje, kompleksne veličine, fazori, harmonijska analiza.',
                'total_copies' => 5,
                'available_copies' => 5,
                'cover_image_url' => null
            ],

            // Electronics
            [
                'title' => 'Elektronski Elementi i Kola',
                'author' => 'Branimir Dolinar',
                'isbn' => '9788679123001',
                'publisher' => 'ETF Beograd',
                'published_year' => 2014,
                'edition' => '4',
                'description' => 'Diodе, tranzistori, pojačavači, operacioni pojačavači.',
                'total_copies' => 4,
                'available_copies' => 4,
                'cover_image_url' => null
            ],
            [
                'title' => 'Analogna Elektronika',
                'author' => 'Dragan Djurić',
                'isbn' => '9788679123003',
                'publisher' => 'ETF Beograd',
                'published_year' => 2017,
                'edition' => '1',
                'description' => 'Analogne komponente, filtri, stabilizatori i pojačavači.',
                'total_copies' => 4,
                'available_copies' => 4,
                'cover_image_url' => null
            ],
            [
                'title' => 'Digitalna Elektronika',
                'author' => 'Zoran Uzelac',
                'isbn' => '9788679123004',
                'publisher' => 'ETF Banja Luka',
                'published_year' => 2020,
                'edition' => '1',
                'description' => 'Logička kola, kombinatorna i sekvencijalna logika, brojni sistemi.',
                'total_copies' => 3,
                'available_copies' => 3,
                'cover_image_url' => null
            ],

            // Programming & CS
            [
                'title' => 'Programiranje u C jeziku',
                'author' => 'Kernighan & Ritchie',
                'isbn' => '9788679101234',
                'publisher' => 'Mikro knjiga',
                'published_year' => 2008,
                'edition' => '3',
                'description' => 'Osnovna struktura C jezika, pokazivači, memorija, standardna biblioteka.',
                'total_copies' => 6,
                'available_copies' => 6,
                'cover_image_url' => null
            ],
            [
                'title' => 'Uvod u Algoritme i Strukture Podataka',
                'author' => 'Marko Marković',
                'isbn' => '9788655123312',
                'publisher' => 'ETF Istočno Sarajevo',
                'published_year' => 2021,
                'edition' => '1',
                'description' => 'Liste, stabla, grafovi, sortiranje i pretrage.',
                'total_copies' => 4,
                'available_copies' => 4,
                'cover_image_url' => null
            ],

            // Signals & Systems
            [
                'title' => 'Teorija Signala i Sistema',
                'author' => 'Zlatko Stanković',
                'isbn' => '9788679123101',
                'publisher' => 'ETF Beograd',
                'published_year' => 2015,
                'edition' => '1',
                'description' => 'Kontinuirani i diskretni signali, transformacije i analiza.',
                'total_copies' => 3,
                'available_copies' => 3,
                'cover_image_url' => null
            ],
            [
                'title' => 'Digitalna Obrada Signala',
                'author' => 'Alan V. Oppenheim',
                'isbn' => '9788679121112',
                'publisher' => 'Mikro knjiga',
                'published_year' => 2016,
                'edition' => '2',
                'description' => 'Furijeove transformacije, filteri, obrada signala u realnom vremenu.',
                'total_copies' => 3,
                'available_copies' => 3,
                'cover_image_url' => null
            ],

            // Communications
            [
                'title' => 'Telekomunikacioni Sistemi',
                'author' => 'Slobodan Miljanović',
                'isbn' => '9788679122001',
                'publisher' => 'ETF Banja Luka',
                'published_year' => 2019,
                'edition' => '1',
                'description' => 'Modulacija, multipleksiranje, mreže, komunikacioni protokoli.',
                'total_copies' => 4,
                'available_copies' => 4,
                'cover_image_url' => null
            ],
            [
                'title' => 'Bežične Komunikacije',
                'author' => 'Theodore Rappaport',
                'isbn' => '9788679125432',
                'publisher' => 'Mikro knjiga',
                'published_year' => 2015,
                'edition' => '3',
                'description' => 'Mobilne mreže, propagacija signala, digitalne radio komunikacije.',
                'total_copies' => 4,
                'available_copies' => 4,
                'cover_image_url' => null
            ],

            // Power Engineering
            [
                'title' => 'Elektroenergetski Sistemi',
                'author' => 'Dušan Lakić',
                'isbn' => '9788679124203',
                'publisher' => 'ETF Beograd',
                'published_year' => 2014,
                'edition' => '1',
                'description' => 'Prijenos energije, mreže, transformatori, zaštita sistema.',
                'total_copies' => 3,
                'available_copies' => 3,
                'cover_image_url' => null
            ],
            [
                'title' => 'Električne Mašine',
                'author' => 'Petar Urošević',
                'isbn' => '9788679127789',
                'publisher' => 'ETF Beograd',
                'published_year' => 2017,
                'edition' => '2',
                'description' => 'Motori, generatori, transformatori, ispravljači.',
                'total_copies' => 3,
                'available_copies' => 3,
                'cover_image_url' => null
            ],

            // Control systems
            [
                'title' => 'Automatsko Upravljanje',
                'author' => 'Miodrag Lazarević',
                'isbn' => '9788679120100',
                'publisher' => 'ETF Banja Luka',
                'published_year' => 2018,
                'edition' => '1',
                'description' => 'Regulatori, povratne sprege, stabilnost upravljačkih sistema.',
                'total_copies' => 4,
                'available_copies' => 4,
                'cover_image_url' => null
            ],

            // Computer architecture
            [
                'title' => 'Arhitektura Računara',
                'author' => 'David Patterson',
                'isbn' => '9788679125111',
                'publisher' => 'Mikro knjiga',
                'published_year' => 2013,
                'edition' => '5',
                'description' => 'Procesori, memorije, I/O sistemi, performanse računara.',
                'total_copies' => 5,
                'available_copies' => 5,
                'cover_image_url' => null
            ],

            // Networking
            [
                'title' => 'Mreže Računara',
                'author' => 'Andrew S. Tanenbaum',
                'isbn' => '9788679121178',
                'publisher' => 'Mikro knjiga',
                'published_year' => 2011,
                'edition' => '5',
                'description' => 'OSI model, protokoli, TCP/IP, umrežavanje.',
                'total_copies' => 5,
                'available_copies' => 5,
                'cover_image_url' => null
            ],

            // Math / Physics
            [
                'title' => 'Matematika 1',
                'author' => 'Jovan Karapandžić',
                'isbn' => '9788679123005',
                'publisher' => 'ETF Istočno Sarajevo',
                'published_year' => 2019,
                'edition' => '1',
                'description' => 'Diferencijalni i integralni račun, linearna algebra.',
                'total_copies' => 6,
                'available_copies' => 6,
                'cover_image_url' => null
            ],
            [
                'title' => 'Fizika u Elektrotehnici',
                'author' => 'Vladimir Maletić',
                'isbn' => '9788679122888',
                'publisher' => 'ETF Banja Luka',
                'published_year' => 2015,
                'edition' => '1',
                'description' => 'Osnovni principi fizike sa primjenama u elektrotehnici.',
                'total_copies' => 5,
                'available_copies' => 5,
                'cover_image_url' => null
            ],

        ];

        foreach ($books as $data) {
            Book::create($data);
        }
    }
}

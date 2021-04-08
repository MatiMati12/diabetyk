# diabetyk
Symulator krzywej cukrowej

Najpierw należy zaimportowac bazę danych na localhoscie z pliku diabetyk.sql , ewentualne parametry zmienić w pliku connect.php przechowującym informacje o parametrach do logowania do bazy danych

Przykładowe dane do logowania:
login:test
hasło:qwerty

Program został napisany w celu stworzenia symulatora krzywych cukrowych.
Główne funkcjonalności programu to:
- dodawanie produktów do bazy (program dodatkowo może obliczyć indeks glikemiczny każdego produktu)
- dodawanie posiłków złożonych  wraz z poziomami cukrów w poszczególnym czasie od zjedzenia posiłku
- obliczanie indeksu glikemicznego całego posiłku 
- dodawanie jedzenia do swojego jadłospisu i wyliczanie na podstwie godziny dodania posiłku krzywej cukrowej
- przeglądanie krzywej cukrowej




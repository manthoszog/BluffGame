Table of Contents
=================
   * [Demo Page](#demo-page)
   * [Εγκατάσταση](#εγκατάσταση)
      * [Απαιτήσεις](#απαιτήσεις)
      * [Οδηγίες Εγκατάστασης](#οδηγίες-εγκατάστασης)
   * [Περιγραφή παιχνιδιού](#περιγραφή-παιχνιδιού)
      * [Συντελεστές](#συντελεστές)
   * [Περιγραφή API](#περιγραφή-api)
      * [Methods](#methods)
         * [Cards](#cards)
            * [Ανάγνωση καρτών](#ανάγνωση-καρτών)
            * [Αρχικοποίηση παιχνιδιού](#αρχικοποίηση-παιχνιδιού)
            * [Μοίρασμα τράπουλας](#μοίρασμα-τράπουλας)
         * [Γύρος παιχνιδιού](#γύρος-παιχνιδιού)
            * [Παίξιμο χαρτιών](#παίξιμο-χαρτιών)
            * [Μπλόφα](#μπλόφα)
         * [Players](#players)
            * [Εισαγωγή παίκτη και καθορισμός των στοιχείων του](#εισαγωγή-παίκτη-και-καθορισμός-των-στοιχείων-του)
         * [Status](#status)
            * [Ανάγνωση κατάστασης παιχνιδιού](#ανάγνωση-κατάστασης-παιχνιδιού)
      * [Entities](#entities)
         * [Κάρτα](#κάρτα)
         * [User](#user)
         * [Game_status](#game_status)


# Demo Page

Για να αποκτήσετε πρόσβαση στο API της εφαρμογής, μπορείτε να χρησιμοποιήσετε το παρακάτω link: 
https://users.iee.ihu.gr/~it185179/ADISE22_Bluff_MZog/www/game.php/



# Εγκατάσταση

## Απαιτήσεις

* Apache2
* Mysql Server
* php

## Οδηγίες Εγκατάστασης

 * Κάντε clone το project σε κάποιον φάκελο <br/>
  `gh repo clone iee-ihu-gr-course1941/ADISE22_Bluff_MZog`

 * Βεβαιωθείτε ότι ο φάκελος είναι προσβάσιμος από τον Apache Server. Πιθανόν να χρειαστεί να καθορίσετε τις παρακάτω ρυθμίσεις:

 * Θα πρέπει να δημιουργήσετε στην Mysql την βάση με όνομα `gamedb` και να φορτώσετε σε αυτήν την βάση τα δεδομένα από το αρχείο `gamedb.sql`

 * Θα πρέπει να φτιάξετε το αρχείο `lib/db_upass.php` το οποίο να περιέχει:
```
    <?php
	$DB_PASS = 'κωδικός';
	$DB_USER = 'όνομα χρήστη';
    ?>
```

# Περιγραφή Παιχνιδιού

Η μπλόφα παίζεται ως εξής: 

Σε κάθε παίκτη μοιράζεται ίσος αριθμός χαρτιών ή μπορεί να μοιραστεί το σύνολο της τράπουλας μέχρι να τελειώσει.
Στην πιο κοινή παραλλαγή μία τράπουλα και όλα τα φύλλα της τράπουλας, συμπεριλαμβανομένων των τζόκερ, χρησιμοποιούνται. 
Ωστόσο, ανάλογα με τον αριθμό των παικτών και την παραλλαγή που παίζεται, μπορεί να χρησιμοποιηθούν περισσότερες από μία τράπουλες, με ή χωρίς τζόκερ.

Οι παίκτες παίζουν με σειρά. Ο πρώτος παίκτης ξεκινάει ρίχνοντας όσα χαρτιά θέλει στη στοίβα, κλειστά, δηλώνοντας την φιγούρα / αριθμό τους. Μπορεί να δηλώσει μόνο μια φιγούρα / αριθμό, π.χ. "τρία δυάρια" ή "τέσσερις βαλέδες".  
Η στοίβα βρίσκεται στο κέντρο του τραπεζιού και περιέχει όλα τα κλειστά φύλλα που έχουν παιχτεί.

Ο δεύτερος παίκτης έχει δύο επιλογές: είτε να ρίξει έναν αριθμό χαρτιών στη στοίβα, κλειστά, δηλώνοντας την φιγούρα / αριθμό τους, όπως έκανε ο πρώτος παίκτης, είτε να δηλώσει "μπλόφα".

Στην περίπτωση που δηλώσει "μπλόφα", ανοίγονται τα χαρτιά από την στοίβα των κλειστών χαρτιών που έριξε ο πρώτος παίκτης και εάν η δήλωσή του αποδειχθεί ψεύτικη, τότε παίρνει όλα τα χαρτιά της στοίβας. Στην αντίθετη περίπτωση, ο παίκτης που δήλωσε "μπλόφα" παίρνει όλα τα χαρτιά της στοίβας.

Νικητής αναδεικνύεται ο παίκτης που απαλάσσεται πρώτος από όλα τα χαρτιά που κρατούσε στα χέρια του.

Η βάση κρατάει τους εξής πίνακες και στοιχεία:

* Ο πίνακας `karta`, περιέχει το σύνολο των 52 καρτών της τράπουλας (δεν περιλαμβάνονται τα τζόκερ), που θα μοιραστούν στους παίκτες. 
* Ο πίνακας `karta_empty`, έχει ακριβώς το ίδιο περιεχόμενο με τον "karta" και έχει βοηθητικό ρόλο στην αρχικοποίηση του παιχνιδιού.
* Ο πίνακας `game_status`, καταγράφει την κατάσταση του παιχνιδιού, με στοιχεία όπως το αν έχει ξεκινήσει ή όχι το παχνίδι, τον παίκτη που έχει σειρά, τον νικητή και την ημερομηνία/ώρα της τελευταίας αλλαγής.
* Ο πίνακας `user`, περιέχει τα στοιχεία των παικτών που συμμετέχουν. Συνολικά υπάρχουν δύο παίκτες στο παιχνίδι.
* Ο πίνακας `player1_karta`, περιέχει τα χαρτιά που έχει στην κατοχή του ο πρώτος παίκτης, μετά το μοίρασμα της τράπουλας.
* Ο πίνακας `player2_karta`, περιέχει τα χαρτιά που έχει στην κατοχή του ο δεύτερος παίκτης, μετά το μοίρασμα της τράπουλας.
* Ο πίνακας `stoiva_karta`, περιέχει τα χαρτιά της στοίβας.
* Ο πίνακας `bluff_table`, περιέχει την "δήλωση" του παίκτη σχετικά με τα κλειστά χαρτιά που έριξε. Χρησιμοποιείται για να ελεγχθεί αν ο παίκτης είπε την αλήθεια ή όχι.
* Η procedure `clean_karta()`, υλοποιεί την επαναφορά του παιχνιδιού στην αρχική του κατάσταση.
* Η procedure `moirasma_kartas()`, υλοποιεί το μοίρασμα των καρτών στους παίκτες. Μοιράζονται όλα τα χαρτιά της τράπουλας, με ίσο αριθμό χαρτιών σε κάθε παίχτη. 
* Η procedure `player1_win()`, υλοποιεί τις απαραίτητες ενέργειες, όταν ο πρώτος παίκτης κερδίζει ένα γύρο του παιχνιδιού.
* Η procedure `player2_win()`, υλοποιεί τις απαραίτητες ενέργειες, όταν ο δεύτερος παίκτης κερδίζει ένα γύρο του παιχνιδιού.


Στην εφαρμογή απαπτύχθηκε μόνο το Web API σε php/mysql, χωρίς GUI, με δυνατότητα να παίζουν δύο παίκτες (human-human), μέσα από Command Line ή από το Postman. Οι λειτουργίες που έχουν υλοποιηθεί είναι οι εξής:
* Αρχικοποίηση σύνδεσης και authentication των χρηστών χωρίς χρήση password, ενώ γίνεται χρήση token.
* Ο πρώτος παίκτης αρχικοποιεί το παιχνίδι και αναμένει τον αντίπαλο.
* Αναγνώριση σειράς παιξίματος.
* Αναγνώριση του τέλους παιχνιδιού ή όταν οι παίκτες είναι ανενεργοί.
* Όπως αναλύθηκε παραπάνω, η κατάσταση του παιχνιδιού αποθηκεύεται πλήρως σε mysql.
* Χρησιμοποιείται json μορφή για τα δεδομένα.
* Γίνεται έλεγχος των κανόνων του παιχνιδιού.



## Συντελεστές

Ματθαίος Ζωγράφος
E-mail: it185179@it.teithe.gr


# Περιγραφή API

## Methods


### Cards
#### Ανάγνωση καρτών

```
GET /cards/
```

Επιστρέφει το σύνολο των [καρτών](#κάρτα) που κατέχουν οι παίκτες, καθώς και αυτές που βρίσκονται στη στοίβα.

#### Αρχικοποίηση παιχνιδιού
```
POST /cards/
```

Γίνεται reset στις [κάρτες](#κάρτα), καθώς και σε ότι έχει σχέση με το παιχνίδι.


#### Μοίρασμα τράπουλας
```
PUT /cards/
```

Μοιράζεται το σύνολο των [χαρτιών](#κάρτα) της τράπουλας στους παίκτες, οι οποίοι λαμβάνουν ίσο αριθμό χαρτιών.


### Γύρος παιχνιδιού
#### Παίξιμο χαρτιών

```
PUT /cards/play/
```
Json Data:

| Field             | Description                 | Required   |
| ----------------- | --------------------------- | ---------- |
| `id1`             | Το id του 1ου χαρτιού από τη Βάση που έριξε ο χρήστης | yes        |
| `id2`             | Το id του 2ου χαρτιού από τη Βάση που έριξε ο χρήστης | yes        |
| `id1_bluff`       | Το id του 1ου χαρτιού από τη Βάση που ο χρήστης δήλωσε ότι έριξε | yes        |
| `id2_bluff`       | Το id του 2ου χαρτιού από τη Βάση που ο χρήστης δήλωσε ότι έριξε | yes        |

Ξεκινάει ένας γύρος του παιχνιδιού. Ο παίκτης που έχει σειρά ρίχνει τα χαρτιά στη στοίβα και στη συνέχεια δηλώνει στον αντίπαλο τον αριθμό/την φιγούρα. Για λόγους συντομίας τους παραδείγματος, ο χρήστης μπορεί να ρίξει μόνο δύο χαρτιά την φορά. 
Εμφανίζονται τα στοιχεία των χαρτιών που δήλωσε ο παίκτης και ακολούθως ερωτάται ο αντιπάλος για το αν θα πει μπλόφα ή όχι. 
Τα χαρτιά που ρίχνει ο παίκτης μεταφέρονται στη στοίβα και δίνεται η σειρά στον επόμενο παίκτη, προκειμένου να απαντήσει, κάνοντας χρήση της μεθόδου [μπλόφα](#μπλόφα).
Ελέγχεται αν η κίνηση του παίκτη είναι ορθή, δηλαδή αν είναι η σειρά του να παίξει με βάση το token και αν το παιχνίδι έχει ξεκινήσει.
Τέλος, γίνεται έλεγχος για το αν υπάρχει νικητής. Νικητής είναι όποιος καταφέρει να ρίξει πρώτος όλα τα χαρτιά του και το παιχνίδι ολοκληρώνεται, με την κατάσταση να αλλάζει σε `ended`.


#### Μπλόφα

```
PUT /cards/bluff/
```
Json Data:

| Field             | Description                 | Required   |
| ----------------- | --------------------------- | ---------- |
| `bluff`           | Η απάντηση του παίκτη για τη μπλόφα | yes        |

Ο παίκτης που έχει σειρά καλείται να αποφασίσει αν θα πει "μπλόφα" ή όχι. 
Εφόσον απαντήσει θετικά, τότε ανοίγονται τα χαρτιά του προηγούμενου παίκτη και γίνεται έλεγχος για το αν είπε την αλήθεια.
Αν προκύψει ότι είχε πει την αλήθεια, τότε ο προηγούμενος παίκτης είναι νικητής του γύρου και ο παίκτης που είπε "μπλόφα" παίρνει όλα τα χαρτιά της στοίβας.
Αν ο προηγούμενος παίκτης είχε πει ψέματα, τότε νικητής είναι ο παίκτης που είπε "μπλόφα" και ο άλλος παίκτης παίρνει όλα τα χαρτιά της στοίβας.
Εφόσον η αρχική απάντηση είναι αρνητική, τότε η ροή του παιχνιδιού συνεχίζεται χωρίς κάποια άλλη ενέργεια.
Σε κάθε περίπτωση, ανεξάρτητα από την απάντηση που θα δώσει ο χρήστης στο ερώτημα, η σειρά παίκτη δεν αλλάζει και ο συγκεκριμένος καλείται στη συνέχεια μέσω της μεθόδου [παίξιμο χαρτιών](#παίξιμο-χαρτιών), να ρίξει τα χαρτιά που επιθυμεί.
Να σημειωθεί ότι και σε αυτές τις περιπτώσεις, πραγματοποιούνται έλεγχοι για το αν η κίνηση του παίκτη είναι ορθή, δηλαδή αν είναι η σειρά του να παίξει με βάση το token και αν το παιχνίδι έχει ξεκινήσει.


### Players

#### Εισαγωγή παίκτη και καθορισμός των στοιχείων του
```
PUT /players/player1
```

```
PUT /players/player2
```

Ο [παίκτης](#user) διαλέγει από τις υπάρχουσες επιλογές στη Βάση Δεδομένων, είτε τον player1, είτε τον player2 και στην συνέχεια γίνεται η δημιουργία και καταχώρηση των στοιχείων του στο παιχνίδι. Επίσης δημιουργείται και ένα token, το οποίο χρησιμοποιείται καθόλη τη διάρκεια του παιχνιδιού προκειμένου να ταυτοποιείται ο χρήστης. Αφού η καταχώρηση ολοκληρωθεί με επιτυχία, εμφανίζονται τα στοιχεία του παίκτη.
Κατά την εκτέλεση, πραγματοποιείται έλεγχος για το αν ο παίκτης υπάρχει ήδη, ώστε να μην μπορεί να ζητηθεί ένα όνομα πάνω από μία φορά.
Τέλος, όταν εισέλθει ο πρώτος παίκτης, το παιχνίδι αρχικοποιείται και η [κατάσταση](#game_status) αλλάζει σε `initialized`. Μόνο όταν συνδεθεί και ο δεύτερος παίκτης, το παιχνίδι μπορεί να αρχίσει, με την κατάσταση να αλλάζει σε `started`. Αν υπάρχει παίκτης που είναι ανενεργός για τουλάχιστον πέντε λεπτά, τότε το παιχνίδι σταματά, ο παίκτης διαγράφεται από το παιχνίδι και η κατάσταση ορίζεται σε `aborted`.

### Status

#### Ανάγνωση κατάστασης παιχνιδιού
```
GET /status/
```

Επιστρέφει το [Game_status](#Game_status), που περιλαμβάνει την πλήρη κατάσταση του παιχνιδιού.



## Entities


### Κάρτα
---------

Υπάρχουν τρεις πίνακες που περιλμβάνουν τις κάρτες του παιχνιδιού. Ο `player1_karta` με τις κάρτες του πρώτου παίκτη, ο `player2_karta` με τις κάρτες του δεύτερου παίκτη, καθώς και ο `stoiva_karta` με τις κάρτες που είναι στη στοίβα. Και οι τρεις πίνακες έχουν πανομοιότυπη μορφή, που είναι η εξής:


| Attribute                | Description                                  | Values                              |
| ------------------------ | -------------------------------------------- | ----------------------------------- |
| `id`                     | Το id του χαρτιού στη Βάση                   | int                                 |
| `arithmos`               | Ο αριθμός/το γράμμα του χαρτιού              | string                              |
| `xroma`                  | To χρώμα του χαρτιού                         | string                              |
| `symvolo`                | To σύμβολο του χαρτιού                       | string                              |


### User
---------

O κάθε χρήστης έχει τα παρακάτω στοιχεία:


| Attribute                | Description                                  | Values                              |
| ------------------------ | -------------------------------------------- | ----------------------------------- |
| `onoma`               | Όνομα παίκτη                                 | 'player1','player2'                              |
| `last_action`            | Τελευταία αλλαγή/ενέργεια του παίκτη                | timestamp                             |
| `token`                | To κρυφό token του παίκτη. Επιστρέφεται μόνο τη στιγμή της εισόδου του παίκτη στο παιχνίδι | HEX |


### Game_status
---------

H κατάσταση παιχνιδιού έχει τα παρακάτω στοιχεία:


| Attribute                | Description                                  | Values                              |
| ------------------------ | -------------------------------------------- | ----------------------------------- |
| `status  `               | Κατάσταση                                    | 'not active', 'initialized', 'started', 'ended', 'aborted'     |
| `player_turn`            | To όνομα του παίκτη που παίζει               | 'player1','player2',null                              |
| `result`                 |  To όνομα του παίκτη που κέρδισε             |'player1','player2',null                              |
| `last_change`            | Τελευταία αλλαγή/ενέργεια στην κατάσταση του παιχνιδιού         | timestamp |
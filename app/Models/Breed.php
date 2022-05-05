<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Breed extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'species_id',
        'name',
    ];

    private static $canineBreeds = [
        'Afghan Hound',
        'Airedale Terrier',
        'Akita',
        'Alaskan Malamute',
        'American Eskimo Dog',
        'American Foxhound',
        'American Staffordshire Terrier',
        'American Water Spaniel',
        'Anatolian Shepherd',
        'Aspin/Mongrel Dog',
        'Australian Cattle Dog',
        'Australian Kelpie',
        'Australian Shepherd',
        'Australian Terrier',
        'Affenpinscher',
        'Basenji',
        'Basset Hound',
        'Beagle',
        'Bearded Collie',
        'Bedlington Terrier',
        'Belgian Malinois',
        'Belgian Sheepdog',
        'Belgian Tervuren',
        'Bernese Mountain Dog',
        'Bichon Frise',
        'Black and Tan Coonhound',
        'Bloodhound',
        'Border Collie',
        'Border Terrier',
        'Borzol',
        'Boston Terrier',
        'Bouvier des Flandres',
        'Boxer',
        'Briard',
        'Brittany',
        'Brussels Griffon',
        'Bull Terrier',
        'Bulldog',
        'Bullmastiff',
        'Cairn Terrier',
        'Canaan Dog',
        'Cardigan Welsh Corgi',
        'Cavalier King Charles Spaniel',
        'Chesapeake Bay Retriever',
        'Chihuahua',
        'Chinese Crested',
        'Chinese Shar-Pei',
        'Chow Chow',
        'Clumber Spaniel',
        'Cocker Spaniel',
        'Collie',
        'Curly-Coated Retriever',
        'Dachshund',
        'Dalmatian',
        'Dandle Dinmont Terrier',
        'Doberman Pinscher',
        'English Cocker Spaniel',
        'English Foxhound',
        'English Setter',
        'English Springer Spaniel',
        'English Toy Spaniel',
        'Field Spaniel',
        'Finnish Spitz',
        'Flat-Coated Retriever',
        'French Bulldog',
        'German Pinscher',
        'German Shepherd Dog',
        'German Shorthaired Pointer',
        'German Wirehaired Pointer',
        'Giant Schnauzer',
        'Golden Retriever',
        'Gordon Setter',
        'Great Dane',
        'Great Pyrenees',
        'Greater Swiss Mountain Dog',
        'Greyhound',
        'Harrier',
        'Havanese',
        'Ibizan Hound',
        'Irish Setter',
        'Irish Terrier',
        'Irish Water Spaniel',
        'Irish Wolfhound',
        'Italian Greyhound',
        'Jack Russell Terrier',
        'Japanese Chin',
        'Keeshond',
        'Kerry Blue Terrier',
        'Komondor',
        'Kuvasz',
        'Labrador Retriever',
        'Lakeland Terrier',
        'Lhasa Apso',
        'Lowchen',
        'Maltese',
        'Manchester Terrier',
        'Mastiff',
        'Miniature Bull Terrier',
        'Miniature Pinscher',
        'Miniature Schnauzer',
        'Newfoundland',
        'Norfolk Terrier',
        'Norwegian Elkhound',
        'Norwich Terrier',
        'Old English Sheepdog',
        'Otterhound',
        'Papillon',
        'Pekingese',
        'Pembroke Welsh Corgi',
        'Petits Bassets Griffons Vendeen',
        'Pharaoh Hound',
        'Plott',
        'Pointer',
        'Polish Lowland Sheepdog',
        'Pomeranian',
        'Poodle',
        'Portuguese Water Dog',
        'Pug',
        'Puli',
        'Rat Terrier',
        'Rhodesian Ridgeback',
        'Rottweiler',
        'Saluki',
        'Samoyed',
        'Schipperke',
        'Scottish Deerhound',
        'Scottish Terrier',
        'Sealyham Terrier',
        'Sheltie',
        'Shetland Sheepdog',
        'Shiba Inu',
        'Shih Tzu',
        'Siberian Husky',
        'Silky Terrier',
        'Skye Terrier',
        'Smooth Fox Terrier',
        'Soft Coated Wheaten Terrier',
        'Spinone Italiano',
        'St. Bernard',
        'Staffordshire Bull Terrier',
        'Standard Schnauzer',
        'Sussex Spaniel',
        'Tibetan Spaniel',
        'Tibetan Terrier',
        'Toy Fox Terrier',
        'Vizsla',
        'Weimaraner',
        'Welsh Springer Spaniel',
        'Welsh Terrier',
        'West Highland White Terrier',
        'Whippet',
        'Wire Fox Terrier',
        'Wirehaired Pointing Griffon',
        'Yorkshire Terrier',
    ];

    private static $felineBreeds = [
        'ABBYSSINIAN',
        'AMERICAN BOBTAIL',
        'AMERICAN CURL',
        'AMERICAN SHORTHAIR',
        'BALINESE',
        'BIRMAN',
        'BOMBAY',
        'BRITISH SHORTHAIR',
        'BURMESE',
        'CHARTRAUX',
        'COLOR-POINT SHORTHAIR',
        'CORNISH REX',
        'CYMRIC',
        'DEVON REX',
        'DOMESTIC LONGHAIR',
        'DOMESTIC MEDIUM HAIR',
        'DOMESTIC SHORTHAIR',
        'EGYPTIAN MAU',
        'EXOTIC SHORTHAIR',
        'HAVANA BROWN',
        'HIMALAYAN',
        'JAPANESE BOBTAIL',
        'JAVANESE',
        'KORAT',
        'LONGHAIRED SCOTTISH FOLD',
        'MAINE COON',
        'MANX',
        'NORWEGIAN FOREST CAT',
        'OCICAT',
        'ORIENTAL LONGHAIR',
        'ORIENTAL SHORTHAIR',
        'PUSPIN/MIXED BREED',
        'PERSIAN',
        'RAGDOLL',
        'RUSSIAN BLUE',
        'SHORTHAIRED SCOTTISH FOLD',
        'SIAMESE',
        'SINGAPURA',
        'SNOSHOE',
        'SOMALI',
        'SPHYNX',
        'TIFFANY',
        'TONKINESE',
        'TURKISH ANGORA',
        'TUXEDO',
        'TURKISH VAN',
    ];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public static function getCanineBreeds()
    {
        return collect(self::$canineBreeds)
            ->map(function ($breed) {
                return Str::upper($breed);
            });
    }

    public static function getFelineBreeds()
    {
        return collect(self::$felineBreeds)
            ->map(function ($breed) {
                return Str::upper($breed);
            });
    }
}

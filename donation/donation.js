let data;
let map;
let marker;

const cityCenterCoordinates = {
    "Adana": { lat: 37.0, lng: 35.3213 },
    "Adıyaman": { lat: 37.7648, lng: 38.2786 },
    "Afyonkarahisar": { lat: 38.7638, lng: 30.5403 },
    "Ağrı": { lat: 39.7191, lng: 43.0513 },
    "Amasya": { lat: 40.6537, lng: 35.8335 },
    "Ankara": { lat: 39.9334, lng: 32.8597 },
    "Antalya": { lat: 36.8969, lng: 30.7133 },
    "Artvin": { lat: 41.1829, lng: 41.8194 },
    "Aydın": { lat: 37.8560, lng: 27.8416 },
    "Balıkesir": { lat: 39.6497, lng: 27.8870 },
    "Bilecik": { lat: 40.1574, lng: 29.0653 },
    "Bingöl": { lat: 38.8846, lng: 40.4938 },
    "Bitlis": { lat: 38.3939, lng: 42.1232 },
    "Bolu": { lat: 40.5760, lng: 31.5788 },
    "Burdur": { lat: 37.7203, lng: 30.2908 },
    "Bursa": { lat: 40.1826, lng: 29.0661 },
    "Çanakkale": { lat: 40.1553, lng: 26.4142 },
    "Çankırı": { lat: 40.6013, lng: 33.6134 },
    "Çorum": { lat: 40.5506, lng: 34.9556 },
    "Denizli": { lat: 37.7765, lng: 29.0864 },
    "Diyarbakır": { lat: 37.9144, lng: 40.2306 },
    "Edirne": { lat: 41.6764, lng: 26.5559 },
    "Elazığ": { lat: 38.6746, lng: 39.2232 },
    "Erzincan": { lat: 39.75, lng: 39.5 },
    "Erzurum": { lat: 39.9043, lng: 41.2679 },
    "Eskişehir": { lat: 39.7667, lng: 30.5256 },
    "Gaziantep": { lat: 37.0662, lng: 37.3833 },
    "Giresun": { lat: 40.9128, lng: 38.3895 },
    "Gümüşhane": { lat: 40.4600, lng: 39.4813 },
    "Hakkari": { lat: 37.5744, lng: 43.7408 },
    "Hatay": { lat: 36.4018, lng: 36.3498 },
    "Isparta": { lat: 37.7648, lng: 30.5566 },
    "Mersin": { lat: 36.8121, lng: 34.6415 },
    "İstanbul": { lat: 41.0082, lng: 28.9784 },
    "İzmir": { lat: 38.4237, lng: 27.1428 },
    "Kars": { lat: 40.5986, lng: 43.0778 },
    "Kastamonu": { lat: 41.3887, lng: 33.7827 },
    "Kayseri": { lat: 38.7312, lng: 35.4787 },
    "Kırklareli": { lat: 41.7351, lng: 27.2254 },
    "Kırşehir": { lat: 39.1428, lng: 34.1709 },
    "Kocaeli": { lat: 40.8533, lng: 29.8815 },
    "Konya": { lat: 37.8667, lng: 32.4833 },
    "Kütahya": { lat: 39.4167, lng: 29.9833 },
    "Malatya": { lat: 38.3552, lng: 38.3095 },
    "Manisa": { lat: 38.6120, lng: 27.4265 },
    "Kahramanmaraş": { lat: 37.5744, lng: 36.9264 },
    "Mardin": { lat: 37.3212, lng: 40.7245 },
    "Muğla": { lat: 37.2153, lng: 28.3636 },
    "Muş": { lat: 38.9462, lng: 41.7539 },
    "Nevşehir": { lat: 38.6247, lng: 34.7144 },
    "Niğde": { lat: 37.9667, lng: 34.6833 },
    "Ordu": { lat: 40.9839, lng: 37.8764 },
    "Rize": { lat: 41.0201, lng: 40.5234 },
    "Sakarya": { lat: 40.6940, lng: 30.4358 },
    "Samsun": { lat: 41.2867, lng: 36.33 },
    "Siirt": { lat: 37.9333, lng: 41.95 },
    "Sinop": { lat: 42.0266, lng: 35.1551 },
    "Sivas": { lat: 39.7483, lng: 37.0161 },
    "Tekirdağ": { lat: 40.9780, lng: 27.5111 },
    "Tokat": { lat: 40.3167, lng: 36.5500 },
    "Trabzon": { lat: 41.0015, lng: 39.7178 },
    "Tunceli": { lat: 39.1080, lng: 39.5473 },
    "Şanlıurfa": { lat: 37.1671, lng: 38.7955 },
    "Uşak": { lat: 38.6823, lng: 29.4082 },
    "Van": { lat: 38.4946, lng: 43.3800 },
    "Yozgat": { lat: 39.8200, lng: 34.8041 },
    "Zonguldak": { lat: 41.4564, lng: 31.7987 },
    "Aksaray": { lat: 38.3687, lng: 34.0360 },
    "Bayburt": { lat: 40.2586, lng: 40.2263 },
    "Karaman": { lat: 37.1759, lng: 33.2287 },
    "Kırıkkale": { lat: 39.8468, lng: 33.5153 },
    "Batman": { lat: 37.8812, lng: 41.1351 },
    "Şırnak": { lat: 37.4187, lng: 42.4918 },
    "Bartın": { lat: 41.6358, lng: 32.3375 },
    "Ardahan": { lat: 41.1105, lng: 42.7022 },
    "Iğdır": { lat: 39.9237, lng: 44.0450 },
    "Yalova": { lat: 40.6500, lng: 29.2747 },
    "Karabük": { lat: 41.2061, lng: 32.6204 },
    "Kilis": { lat: 36.7184, lng: 37.1212 },
    "Osmaniye": { lat: 37.0743, lng: 36.2476 },
    "Düzce": { lat: 40.8438, lng: 31.1565 }
};

const districtCenterCoordinates = {
    "İstanbul": {
        "Adalar": { lat: 40.8677, lng: 29.1333 },
        "Arnavutköy": { lat: 41.1964, lng: 28.7406 },
        "Ataşehir": { lat: 40.9927, lng: 29.1244 },
        "Avcılar": { lat: 40.9792, lng: 28.7214 },
        "Bağcılar": { lat: 41.0390, lng: 28.8567 },
        "Bahçelievler": { lat: 40.9922, lng: 28.8597 },
        "Bakırköy": { lat: 40.9820, lng: 28.8799 },
        "Başakşehir": { lat: 41.0931, lng: 28.8020 },
        "Bayrampaşa": { lat: 41.0453, lng: 28.9019 },
        "Beşiktaş": { lat: 41.0425, lng: 29.0100 },
        "Beykoz": { lat: 41.0908, lng: 29.0894 },
        "Beylikdüzü": { lat: 40.9819, lng: 28.6400 },
        "Beyoğlu": { lat: 41.0370, lng: 28.9773 },
        "Büyükçekmece": { lat: 41.0247, lng: 28.5853 },
        "Çatalca": { lat: 41.1436, lng: 28.4611 },
        "Çekmeköy": { lat: 41.0364, lng: 29.1814 },
        "Esenler": { lat: 41.0792, lng: 28.8764 },
        "Esenyurt": { lat: 40.9975, lng: 28.6753 },
        "Eyüp": { lat: 41.0447, lng: 28.9339 },
        "Fatih": { lat: 41.0082, lng: 28.9784 },
        "Gaziosmanpaşa": { lat: 41.0694, lng: 28.9019 },
        "Güngören": { lat: 41.0167, lng: 28.8833 },
        "Kadıköy": { lat: 40.9905, lng: 29.0264 },
        "Kağıthane": { lat: 41.0719, lng: 28.9664 },
        "Kartal": { lat: 40.9033, lng: 29.1725 },
        "Küçükçekmece": { lat: 41.0167, lng: 28.8000 },
        "Maltepe": { lat: 40.9358, lng: 29.1511 },
        "Pendik": { lat: 40.8775, lng: 29.2353 },
        "Sancaktepe": { lat: 41.0025, lng: 29.2319 },
        "Sarıyer": { lat: 41.1667, lng: 29.0500 },
        "Silivri": { lat: 41.0739, lng: 28.2464 },
        "Sultanbeyli": { lat: 40.9608, lng: 29.2706 },
        "Sultangazi": { lat: 41.1069, lng: 28.8681 },
        "Şile": { lat: 41.1753, lng: 29.6139 },
        "Şişli": { lat: 41.0603, lng: 28.9878 },
        "Tuzla": { lat: 40.8693, lng: 29.2951 },
        "Ümraniye": { lat: 41.0167, lng: 29.1167 },
        "Üsküdar": { lat: 41.0225, lng: 29.0136 },
        "Zeytinburnu": { lat: 40.9833, lng: 28.9000 }
    },
    "Ankara": {
        "Akyurt": { lat: 40.1333, lng: 33.0833 },
        "Altındağ": { lat: 39.9667, lng: 32.8667 },
        "Ayaş": { lat: 40.0167, lng: 32.3333 },
        "Bala": { lat: 39.5500, lng: 33.1167 },
        "Beypazarı": { lat: 40.1667, lng: 31.9167 },
        "Çamlıdere": { lat: 40.4833, lng: 32.4667 },
        "Çankaya": { lat: 39.9167, lng: 32.8333 },
        "Çubuk": { lat: 40.2333, lng: 33.0333 },
        "Elmadağ": { lat: 39.9167, lng: 33.2333 },
        "Etimesgut": { lat: 39.9500, lng: 32.6333 },
        "Evren": { lat: 39.0167, lng: 33.8000 },
        "Gölbaşı": { lat: 39.7833, lng: 32.8000 },
        "Güdül": { lat: 40.2167, lng: 32.2500 },
        "Haymana": { lat: 39.4333, lng: 32.5000 },
        "Kalecik": { lat: 40.1000, lng: 33.4167 },
        "Kazan": { lat: 40.2333, lng: 32.6833 },
        "Keçiören": { lat: 40.0000, lng: 32.8667 },
        "Kızılcahamam": { lat: 40.4667, lng: 32.6500 },
        "Mamak": { lat: 39.9500, lng: 32.9167 },
        "Nallıhan": { lat: 40.1833, lng: 31.3500 },
        "Polatlı": { lat: 39.5833, lng: 32.1500 },
        "Pursaklar": { lat: 40.0500, lng: 32.8000 },
        "Sincan": { lat: 39.9667, lng: 32.5667 },
        "Şereflikoçhisar": { lat: 38.9500, lng: 33.5500 },
        "Yenimahalle": { lat: 39.9667, lng: 32.8000 }
    },
    "İzmir": {
        "Aliağa": { lat: 38.8000, lng: 26.9667 },
        "Balçova": { lat: 38.3833, lng: 27.0667 },
        "Bayındır": { lat: 38.2167, lng: 27.6500 },
        "Bayraklı": { lat: 38.4667, lng: 27.1667 },
        "Bergama": { lat: 39.1167, lng: 27.1833 },
        "Beydağ": { lat: 38.0833, lng: 28.2000 },
        "Bornova": { lat: 38.4667, lng: 27.2167 },
        "Buca": { lat: 38.3833, lng: 27.1667 },
        "Çeşme": { lat: 38.3167, lng: 26.3000 },
        "Çiğli": { lat: 38.5000, lng: 27.0667 },
        "Dikili": { lat: 39.0667, lng: 26.8833 },
        "Foça": { lat: 38.6667, lng: 26.7500 },
        "Gaziemir": { lat: 38.3167, lng: 27.1167 },
        "Güzelbahçe": { lat: 38.3667, lng: 26.9000 },
        "Karabağlar": { lat: 38.3667, lng: 27.1167 },
        "Karaburun": { lat: 38.6333, lng: 26.5000 },
        "Karşıyaka": { lat: 38.4500, lng: 27.1167 },
        "Kemalpaşa": { lat: 38.4167, lng: 27.4167 },
        "Kınık": { lat: 39.0833, lng: 27.3833 },
        "Kiraz": { lat: 38.2333, lng: 28.2000 },
        "Konak": { lat: 38.4167, lng: 27.1500 },
        "Menderes": { lat: 38.2500, lng: 27.1333 },
        "Menemen": { lat: 38.6000, lng: 27.0667 },
        "Narlıdere": { lat: 38.3833, lng: 27.0000 },
        "Ödemiş": { lat: 38.2333, lng: 27.9667 },
        "Seferihisar": { lat: 38.2000, lng: 26.8333 },
        "Selçuk": { lat: 37.9500, lng: 27.3667 },
        "Tire": { lat: 38.0833, lng: 27.7333 },
        "Torbalı": { lat: 38.1667, lng: 27.3500 },
        "Urla": { lat: 38.3167, lng: 26.7667 }
    },
    "Bursa": {
        "Büyükorhan": { lat: 39.7667, lng: 28.8833 },
        "Gemlik": { lat: 40.4333, lng: 29.1667 },
        "Gürsu": { lat: 40.2167, lng: 29.1833 },
        "Harmancık": { lat: 39.6667, lng: 29.1500 },
        "İnegöl": { lat: 40.0833, lng: 29.5167 },
        "İznik": { lat: 40.4333, lng: 29.7167 },
        "Karacabey": { lat: 40.2167, lng: 28.3500 },
        "Keles": { lat: 39.9167, lng: 29.2333 },
        "Kestel": { lat: 40.2000, lng: 29.2167 },
        "Mudanya": { lat: 40.3833, lng: 28.8833 },
        "Mustafakemalpaşa": { lat: 40.0333, lng: 28.4000 },
        "Nilüfer": { lat: 40.2833, lng: 28.9500 },
        "Orhaneli": { lat: 39.9000, lng: 28.9833 },
        "Orhangazi": { lat: 40.4833, lng: 29.3000 },
        "Osmangazi": { lat: 40.1833, lng: 29.0500 },
        "Yenişehir": { lat: 40.2667, lng: 29.6500 },
        "Yıldırım": { lat: 40.1833, lng: 29.0833 }
    },
    "Antalya": {
        "Akseki": { lat: 37.0500, lng: 31.7833 },
        "Aksu": { lat: 36.9500, lng: 30.8500 },
        "Alanya": { lat: 36.5500, lng: 32.0000 },
        "Demre": { lat: 36.2333, lng: 29.9833 },
        "Döşemealtı": { lat: 37.0167, lng: 30.6000 },
        "Elmalı": { lat: 36.7333, lng: 29.9167 },
        "Finike": { lat: 36.3000, lng: 30.1500 },
        "Gazipaşa": { lat: 36.2667, lng: 32.3167 },
        "Gündoğmuş": { lat: 36.8167, lng: 31.9833 },
        "İbradı": { lat: 37.1000, lng: 31.6000 },
        "Kaş": { lat: 36.2000, lng: 29.6333 },
        "Kemer": { lat: 36.6000, lng: 30.5667 },
        "Kepez": { lat: 36.9833, lng: 30.7000 },
        "Konyaaltı": { lat: 36.8833, lng: 30.6500 },
        "Korkuteli": { lat: 37.0667, lng: 30.2000 },
        "Kumluca": { lat: 36.3667, lng: 30.2833 },
        "Manavgat": { lat: 36.7833, lng: 31.4333 },
        "Muratpaşa": { lat: 36.8833, lng: 30.7667 },
        "Serik": { lat: 36.9167, lng: 31.1000 }
    },
    "Adana": {
        "Aladağ": { lat: 37.5500, lng: 35.4000 },
        "Ceyhan": { lat: 37.0167, lng: 35.8167 },
        "Çukurova": { lat: 37.0000, lng: 35.3000 },
        "Feke": { lat: 37.8167, lng: 35.9167 },
        "İmamoğlu": { lat: 37.2667, lng: 35.6667 },
        "Karaisalı": { lat: 37.2500, lng: 35.0667 },
        "Karataş": { lat: 36.5667, lng: 35.3833 },
        "Kozan": { lat: 37.4500, lng: 35.8167 },
        "Pozantı": { lat: 37.4167, lng: 34.8667 },
        "Saimbeyli": { lat: 37.9833, lng: 36.0833 },
        "Sarıçam": { lat: 37.1667, lng: 35.5000 },
        "Seyhan": { lat: 37.0000, lng: 35.3000 },
        "Tufanbeyli": { lat: 38.2667, lng: 36.2167 },
        "Yumurtalık": { lat: 36.7667, lng: 35.7833 },
        "Yüreğir": { lat: 37.0000, lng: 35.3000 }
    },
    "Konya": {
        "Ahırlı": { lat: 37.2500, lng: 32.1167 },
        "Akören": { lat: 37.4500, lng: 32.3667 },
        "Akşehir": { lat: 38.3500, lng: 31.4167 },
        "Altınekin": { lat: 38.3000, lng: 32.8667 },
        "Beyşehir": { lat: 37.6833, lng: 31.7167 },
        "Bozkır": { lat: 37.1833, lng: 32.2500 },
        "Çeltik": { lat: 39.0333, lng: 31.7833 },
        "Çumra": { lat: 37.5667, lng: 32.7667 },
        "Derbent": { lat: 38.0167, lng: 32.0167 },
        "Derebucak": { lat: 37.3833, lng: 31.5167 },
        "Doğanhisar": { lat: 38.1500, lng: 31.6667 },
        "Emirgazi": { lat: 37.9000, lng: 33.8333 },
        "Ereğli": { lat: 37.5167, lng: 34.0500 },
        "Güneysınır": { lat: 37.2667, lng: 32.7333 },
        "Hadim": { lat: 36.9833, lng: 32.4500 },
        "Halkapınar": { lat: 37.4333, lng: 34.1833 },
        "Hüyük": { lat: 37.9500, lng: 31.6000 },
        "Ilgın": { lat: 38.2833, lng: 31.9167 },
        "Kadınhanı": { lat: 38.2333, lng: 32.2167 },
        "Karapınar": { lat: 37.7167, lng: 33.5500 },
        "Karatay": { lat: 37.8667, lng: 32.8667 },
        "Kulu": { lat: 39.0833, lng: 33.0833 },
        "Meram": { lat: 37.8333, lng: 32.4333 },
        "Sarayönü": { lat: 38.2667, lng: 32.4000 },
        "Selçuklu": { lat: 37.8833, lng: 32.4833 },
        "Seydişehir": { lat: 37.4167, lng: 31.8500 },
        "Taşkent": { lat: 36.9167, lng: 32.5000 },
        "Tuzlukçu": { lat: 38.4833, lng: 31.6167 },
        "Yalıhüyük": { lat: 37.3000, lng: 32.0833 },
        "Yunak": { lat: 38.8167, lng: 31.7333 }
    },
    "Gaziantep": {
        "Şahinbey": { lat: 37.0667, lng: 37.3833 },
        "Şehitkamil": { lat: 37.0667, lng: 37.3833 },
        "Oğuzeli": { lat: 36.9667, lng: 37.5167 },
        "Yavuzeli": { lat: 37.3167, lng: 37.5667 },
        "Araban": { lat: 37.4167, lng: 37.6833 },
        "İslahiye": { lat: 37.0167, lng: 36.6333 },
        "Karkamış": { lat: 36.8333, lng: 37.9833 },
        "Nizip": { lat: 37.0167, lng: 37.8000 },
        "Nurdağı": { lat: 37.1667, lng: 36.7333 }
    },
    "Şanlıurfa": {
        "Eyyübiye": { lat: 37.1500, lng: 38.8000 },
        "Haliliye": { lat: 37.1500, lng: 38.8000 },
        "Karaköprü": { lat: 37.1500, lng: 38.8000 },
        "Akçakale": { lat: 36.7167, lng: 38.9500 },
        "Birecik": { lat: 37.0167, lng: 37.9833 },
        "Bozova": { lat: 37.3667, lng: 38.5167 },
        "Ceylanpınar": { lat: 36.8500, lng: 40.0500 },
        "Halfeti": { lat: 37.2500, lng: 37.8667 },
        "Harran": { lat: 36.8667, lng: 39.0333 },
        "Hilvan": { lat: 37.5833, lng: 38.9500 },
        "Siverek": { lat: 37.7500, lng: 39.3167 },
        "Suruç": { lat: 36.9833, lng: 38.4333 },
        "Viranşehir": { lat: 37.2333, lng: 39.7667 }
    },
    "Diyarbakır": {
        "Bağlar": { lat: 37.9167, lng: 40.2167 },
        "Kayapınar": { lat: 37.9167, lng: 40.2167 },
        "Sur": { lat: 37.9167, lng: 40.2167 },
        "Yenişehir": { lat: 37.9167, lng: 40.2167 },
        "Bismil": { lat: 37.8500, lng: 40.6667 },
        "Çermik": { lat: 38.1333, lng: 39.4500 },
        "Çınar": { lat: 37.7167, lng: 40.4167 },
        "Çüngüş": { lat: 38.2167, lng: 39.2833 },
        "Dicle": { lat: 38.3667, lng: 40.0667 },
        "Eğil": { lat: 38.2500, lng: 40.0833 },
        "Ergani": { lat: 38.2667, lng: 39.7667 },
        "Hani": { lat: 38.4167, lng: 40.3833 },
        "Hazro": { lat: 38.2500, lng: 40.7833 },
        "Kocasöğüt": { lat: 37.8500, lng: 40.5000 },
        "Kulp": { lat: 38.5000, lng: 41.0000 },
        "Lice": { lat: 38.4667, lng: 40.6500 },
        "Silvan": { lat: 38.1333, lng: 41.0000 }
    },
    "Mersin": {
        "Akdeniz": { lat: 36.8000, lng: 34.6333 },
        "Mezitli": { lat: 36.8000, lng: 34.6333 },
        "Toroslar": { lat: 36.8000, lng: 34.6333 },
        "Yenişehir": { lat: 36.8000, lng: 34.6333 },
        "Anamur": { lat: 36.0833, lng: 32.8333 },
        "Aydıncık": { lat: 36.1333, lng: 33.3167 },
        "Bozyazı": { lat: 36.1000, lng: 32.9667 },
        "Çamlıyayla": { lat: 37.1667, lng: 34.6000 },
        "Erdemli": { lat: 36.6000, lng: 34.3000 },
        "Gülnar": { lat: 36.3333, lng: 33.4000 },
        "Mut": { lat: 36.6500, lng: 33.4333 },
        "Silifke": { lat: 36.3833, lng: 33.9333 },
        "Tarsus": { lat: 36.9167, lng: 34.9000 }
    },
    "Hatay": {
        "Altınözü": { lat: 36.1167, lng: 36.2500 },
        "Antakya": { lat: 36.2000, lng: 36.1500 },
        "Arsuz": { lat: 36.4167, lng: 35.8500 },
        "Belen": { lat: 36.4833, lng: 36.2000 },
        "Defne": { lat: 36.2000, lng: 36.1500 },
        "Dörtyol": { lat: 36.8500, lng: 36.2167 },
        "Erzin": { lat: 36.9500, lng: 36.2000 },
        "Hassa": { lat: 36.8000, lng: 36.5167 },
        "İskenderun": { lat: 36.5833, lng: 36.1667 },
        "Kırıkhan": { lat: 36.5000, lng: 36.3500 },
        "Kumlu": { lat: 36.3667, lng: 36.4500 },
        "Payas": { lat: 36.7500, lng: 36.2167 },
        "Reyhanlı": { lat: 36.2667, lng: 36.5667 },
        "Samandağ": { lat: 36.0833, lng: 35.9833 },
        "Yayladağı": { lat: 35.9000, lng: 36.0667 }
    },
    "Trabzon": {
        "Akçaabat": { lat: 41.0167, lng: 39.5667 },
        "Araklı": { lat: 40.9167, lng: 40.0667 },
        "Arsin": { lat: 40.9167, lng: 39.9333 },
        "Beşikdüzü": { lat: 41.0500, lng: 39.2333 },
        "Çarşıbaşı": { lat: 41.0333, lng: 39.4000 },
        "Çaykara": { lat: 40.7500, lng: 40.2333 },
        "Dernekpazarı": { lat: 40.8000, lng: 40.2333 },
        "Düzköy": { lat: 40.8667, lng: 39.4167 },
        "Hayrat": { lat: 40.8833, lng: 40.3667 },
        "Köprübaşı": { lat: 40.8000, lng: 40.1167 },
        "Maçka": { lat: 40.8167, lng: 39.6167 },
        "Of": { lat: 40.9500, lng: 40.2667 },
        "Ortahisar": { lat: 41.0000, lng: 39.7167 },
        "Sürmene": { lat: 40.9167, lng: 40.1167 },
        "Şalpazarı": { lat: 40.9333, lng: 39.1833 },
        "Tonya": { lat: 40.8833, lng: 39.2833 },
        "Vakfıkebir": { lat: 41.0500, lng: 39.2833 },
        "Yomra": { lat: 40.9500, lng: 39.8667 }
    },
    "Van": {
        "Bahçesaray": { lat: 38.1167, lng: 42.8000 },
        "Başkale": { lat: 38.0500, lng: 44.0167 },
        "Çaldıran": { lat: 39.1333, lng: 43.9167 },
        "Çatak": { lat: 38.0000, lng: 43.0667 },
        "Edremit": { lat: 38.4167, lng: 43.2500 },
        "Erciş": { lat: 39.0333, lng: 43.3667 },
        "Gevaş": { lat: 38.2833, lng: 43.1000 },
        "Gürpınar": { lat: 38.3167, lng: 43.4000 },
        "İpekyolu": { lat: 38.5000, lng: 43.3833 },
        "Muradiye": { lat: 38.9833, lng: 43.7667 },
        "Özalp": { lat: 38.6500, lng: 43.9833 },
        "Saray": { lat: 38.6500, lng: 44.1667 },
        "Tuşba": { lat: 38.5000, lng: 43.3833 }
    },
    "Samsun": {
        "Alaçam": { lat: 41.6000, lng: 35.6000 },
        "Asarcık": { lat: 41.0333, lng: 36.2167 },
        "Atakum": { lat: 41.2833, lng: 36.3333 },
        "Ayvacık": { lat: 40.9833, lng: 36.6833 },
        "Bafra": { lat: 41.5667, lng: 35.9000 },
        "Canik": { lat: 41.2833, lng: 36.3333 },
        "Çarşamba": { lat: 41.2000, lng: 36.7333 },
        "Havza": { lat: 40.9667, lng: 35.6667 },
        "İlkadım": { lat: 41.2833, lng: 36.3333 },
        "Kavak": { lat: 41.0667, lng: 36.0333 },
        "Ladik": { lat: 40.9167, lng: 35.8833 },
        "Ondokuzmayıs": { lat: 41.5000, lng: 36.0833 },
        "Salıpazarı": { lat: 41.0833, lng: 36.8333 },
        "Tekkeköy": { lat: 41.2167, lng: 36.4667 },
        "Terme": { lat: 41.2000, lng: 36.9667 },
        "Vezirköprü": { lat: 41.1333, lng: 35.4667 },
        "Yakakent": { lat: 41.6333, lng: 35.5333 }
    },
    "Sakarya": {
        "Adapazarı": { lat: 40.7667, lng: 30.4000 },
        "Akyazı": { lat: 40.6833, lng: 30.6167 },
        "Arifiye": { lat: 40.7167, lng: 30.3667 },
        "Erenler": { lat: 40.7667, lng: 30.4000 },
        "Ferizli": { lat: 40.9333, lng: 30.4833 },
        "Geyve": { lat: 40.5000, lng: 30.2833 },
        "Hendek": { lat: 40.8000, lng: 30.7500 },
        "Karapürçek": { lat: 40.6333, lng: 30.5333 },
        "Karasu": { lat: 41.1000, lng: 30.6833 },
        "Kaynarca": { lat: 41.0333, lng: 30.3000 },
        "Kocaali": { lat: 41.0500, lng: 30.8500 },
        "Pamukova": { lat: 40.5000, lng: 30.1667 },
        "Sapanca": { lat: 40.6833, lng: 30.2667 },
        "Serdivan": { lat: 40.7667, lng: 30.4000 },
        "Söğütlü": { lat: 40.9000, lng: 30.4667 },
        "Taraklı": { lat: 40.4000, lng: 30.5000 }
    },
    "Kocaeli": {
        "Başiskele": { lat: 40.7167, lng: 29.9167 },
        "Çayırova": { lat: 40.8167, lng: 29.3833 },
        "Darıca": { lat: 40.7667, lng: 29.3833 },
        "Derince": { lat: 40.7667, lng: 29.8167 },
        "Dilovası": { lat: 40.7833, lng: 29.5333 },
        "Gebze": { lat: 41.3000, lng: 29.4333 },
        "Gölcük": { lat: 40.7167, lng: 29.8167 },
        "İzmit": { lat: 40.7667, lng: 29.9167 },
        "Kandıra": { lat: 41.0667, lng: 30.1500 },
        "Karamürsel": { lat: 40.6833, lng: 29.6167 },
        "Kartepe": { lat: 40.7500, lng: 30.0333 },
        "Körfez": { lat: 40.7667, lng: 29.7500 }
    },
    "Eskişehir": {
        "Alpu": { lat: 39.7667, lng: 30.9667 },
        "Beylikova": { lat: 39.6833, lng: 31.2000 },
        "Çifteler": { lat: 39.3833, lng: 31.0333 },
        "Günyüzü": { lat: 39.3833, lng: 31.8000 },
        "Han": { lat: 39.1667, lng: 30.8500 },
        "İnönü": { lat: 39.8167, lng: 30.1333 },
        "Mahmudiye": { lat: 39.5000, lng: 30.9833 },
        "Mihalgazi": { lat: 40.0167, lng: 30.5667 },
        "Mihalıççık": { lat: 39.8667, lng: 31.5000 },
        "Odunpazarı": { lat: 39.7667, lng: 30.5167 },
        "Sarıcakaya": { lat: 40.0333, lng: 30.6167 },
        "Seyitgazi": { lat: 39.4333, lng: 30.7000 },
        "Sivrihisar": { lat: 39.4500, lng: 31.5333 },
        "Tepebaşı": { lat: 39.7667, lng: 30.5167 }
    },
    "Denizli": {
        "Acıpayam": { lat: 37.4167, lng: 29.3500 },
        "Babadağ": { lat: 37.8000, lng: 28.8500 },
        "Baklan": { lat: 37.9833, lng: 29.6000 },
        "Bekilli": { lat: 38.2333, lng: 29.4167 },
        "Beyağaç": { lat: 37.2333, lng: 28.9000 },
        "Bozkurt": { lat: 37.8167, lng: 29.6000 },
        "Buldan": { lat: 38.0500, lng: 28.8333 },
        "Çal": { lat: 38.0833, lng: 29.4000 },
        "Çameli": { lat: 37.0833, lng: 29.3333 },
        "Çardak": { lat: 37.8167, lng: 29.7000 },
        "Çivril": { lat: 38.3000, lng: 29.7333 },
        "Güney": { lat: 38.1500, lng: 29.0667 },
        "Honaz": { lat: 37.7500, lng: 29.2833 },
        "Kale": { lat: 37.4333, lng: 28.8333 },
        "Merkezefendi": { lat: 37.7833, lng: 29.0833 },
        "Pamukkale": { lat: 37.9167, lng: 29.1167 },
        "Sarayköy": { lat: 37.9167, lng: 28.9167 },
        "Serinhisar": { lat: 37.5833, lng: 29.2667 },
        "Tavas": { lat: 37.5667, lng: 29.0667 }
    },
    "Malatya": {
        "Akçadağ": { lat: 38.3333, lng: 37.9667 },
        "Arapgir": { lat: 39.0333, lng: 38.4833 },
        "Arguvan": { lat: 38.7833, lng: 38.2667 },
        "Battalgazi": { lat: 38.4167, lng: 38.7500 },
        "Darende": { lat: 38.5500, lng: 37.5000 },
        "Doğanşehir": { lat: 38.0833, lng: 37.8833 },
        "Doğanyol": { lat: 38.3000, lng: 39.0333 },
        "Hekimhan": { lat: 38.8167, lng: 37.9333 },
        "Kale": { lat: 38.4000, lng: 38.7500 },
        "Kuluncak": { lat: 38.8833, lng: 37.6667 },
        "Pütürge": { lat: 38.2000, lng: 38.8667 },
        "Yazıhan": { lat: 38.6000, lng: 38.1833 },
        "Yeşilyurt": { lat: 38.3000, lng: 38.2500 }
    },
    "Kahramanmaraş": {
        "Afşin": { lat: 38.2500, lng: 36.9167 },
        "Andırın": { lat: 37.5833, lng: 36.3500 },
        "Çağlayancerit": { lat: 37.7500, lng: 37.2833 },
        "Dulkadiroğlu": { lat: 37.5833, lng: 36.9333 },
        "Ekinözü": { lat: 38.0667, lng: 37.1833 },
        "Elbistan": { lat: 38.2000, lng: 37.1833 },
        "Göksun": { lat: 38.0167, lng: 36.5000 },
        "Nurhak": { lat: 37.9667, lng: 37.4167 },
        "Onikişubat": { lat: 37.5833, lng: 36.9333 },
        "Pazarcık": { lat: 37.4833, lng: 37.3000 },
        "Türkoğlu": { lat: 37.3833, lng: 36.8500 }
    },
    "Mardin": {
        "Artuklu": { lat: 37.3167, lng: 40.7333 },
        "Dargeçit": { lat: 37.5500, lng: 41.7167 },
        "Derik": { lat: 37.3667, lng: 40.2667 },
        "Kızıltepe": { lat: 37.1833, lng: 40.5833 },
        "Mazıdağı": { lat: 37.4833, lng: 40.4833 },
        "Midyat": { lat: 37.4167, lng: 41.3667 },
        "Nusaybin": { lat: 37.0667, lng: 41.2167 },
        "Ömerli": { lat: 37.4000, lng: 40.9500 },
        "Savur": { lat: 37.5333, lng: 40.8833 },
        "Yeşilli": { lat: 37.3333, lng: 40.8167 }
    },
    "Muğla": {
        "Bodrum": { lat: 37.0333, lng: 27.4333 },
        "Dalaman": { lat: 36.7667, lng: 28.8000 },
        "Datça": { lat: 36.7333, lng: 27.6833 },
        "Fethiye": { lat: 36.6500, lng: 29.1167 },
        "Kavaklıdere": { lat: 37.4333, lng: 28.3667 },
        "Köyceğiz": { lat: 36.9667, lng: 28.6833 },
        "Marmaris": { lat: 36.8500, lng: 28.2667 },
        "Menteşe": { lat: 37.2167, lng: 28.3667 },
        "Milas": { lat: 37.3167, lng: 27.7833 },
        "Ortaca": { lat: 36.8333, lng: 28.7667 },
        "Seydikemer": { lat: 36.6500, lng: 29.1167 },
        "Ula": { lat: 37.1000, lng: 28.4167 },
        "Yatağan": { lat: 37.3333, lng: 28.1333 }
    },
    "Aydın": {
        "Bozdoğan": { lat: 37.6667, lng: 28.3167 },
        "Buharkent": { lat: 37.9667, lng: 28.7500 },
        "Çine": { lat: 37.6167, lng: 28.0667 },
        "Didim": { lat: 37.3833, lng: 27.2667 },
        "Efeler": { lat: 37.8500, lng: 27.8500 },
        "Germencik": { lat: 37.8667, lng: 27.6000 },
        "İncirliova": { lat: 37.8500, lng: 27.7167 },
        "Karacasu": { lat: 37.7167, lng: 28.6000 },
        "Karpuzlu": { lat: 37.5500, lng: 27.8333 },
        "Koçarlı": { lat: 37.7500, lng: 27.7000 },
        "Köşk": { lat: 37.8500, lng: 28.0500 },
        "Kuşadası": { lat: 37.8500, lng: 27.2500 },
        "Kuyucak": { lat: 37.9167, lng: 28.4500 },
        "Nazilli": { lat: 37.9167, lng: 28.3167 },
        "Söke": { lat: 37.7500, lng: 27.4000 },
        "Sultanhisar": { lat: 37.8833, lng: 28.1500 },
        "Yenipazar": { lat: 37.8333, lng: 28.2000 }
    }
};

// JSON verisini fetch API ile çek
fetch('data.json')
    .then(response => response.json())
    .then(json => {
        data = json;
        populateCitySelect();
    });

function populateCitySelect() {
    const citySelect = document.getElementById("city");
    data.forEach(city => {
        const option = document.createElement("option");
        option.value = city.name;
        option.textContent = city.name;
        citySelect.appendChild(option);
    });
}

function updateDistricts() {
    const citySelect = document.getElementById("city");
    const districtSelect = document.getElementById("district");
    const selectedCity = citySelect.value;

    if (selectedCity && cityCenterCoordinates[selectedCity]) {
        map.setCenter(cityCenterCoordinates[selectedCity]);
        map.setZoom(10);
    }

    districtSelect.innerHTML = '<option value="">Seçiniz</option>';
    const city = data.find(city => city.name === selectedCity);
    if (city) {
        city.towns.forEach(town => {
            const option = document.createElement("option");
            option.value = town.name;
            option.textContent = town.name;
            districtSelect.appendChild(option);
        });
    }
    updateNeighborhoods();
}

function updateNeighborhoods() {
    const citySelect = document.getElementById("city");
    const districtSelect = document.getElementById("district");
    const neighborhoodSelect = document.getElementById("neighborhood");
    const selectedCity = citySelect.value;
    const selectedDistrict = districtSelect.value;

    if (selectedCity && selectedDistrict && districtCenterCoordinates[selectedCity] && districtCenterCoordinates[selectedCity][selectedDistrict]) {
        map.setCenter(districtCenterCoordinates[selectedCity][selectedDistrict]);
        map.setZoom(13);
    }

    neighborhoodSelect.innerHTML = '<option value="">Seçiniz</option>';
    const city = data.find(city => city.name === selectedCity);
    if (city) {
        const town = city.towns.find(town => town.name === selectedDistrict);
        if (town) {
            town.districts.forEach(district => {
                district.quarters.forEach(neighborhood => {
                    const option = document.createElement("option");
                    option.value = neighborhood.name;
                    option.textContent = neighborhood.name;
                    neighborhoodSelect.appendChild(option);
                });
            });
        }
    }
}

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 39.9334, lng: 32.8597 }, // Türkiye'nin merkezi (Ankara)
        zoom: 7,
        mapTypeId: 'roadmap',
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: true,
        restriction: {
            latLngBounds: {
                north: 43,
                south: 34,
                west: 24,
                east: 45
            },
            strictBounds: true
        }
    });

    map.addListener('dblclick', function(event) {
        placeMarkerAndPanTo(event.latLng, map);
    });
}

function placeMarkerAndPanTo(latLng, map) {
    if (marker) {
        marker.setPosition(latLng);
    } else {
        marker = new google.maps.Marker({
            position: latLng,
            map: map
        });
    }
    map.panTo(latLng);
    document.getElementById('latitude').value = latLng.lat();
    document.getElementById('longitude').value = latLng.lng();
    console.log('Latitude: ' + latLng.lat() + ', Longitude: ' + latLng.lng());
}

function submitForm() {
    const formData = new FormData(document.getElementById('donationForm'));
    formData.append('latitude', marker.getPosition().lat());
    formData.append('longitude', marker.getPosition().lng());

    fetch('save_data.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        } else {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Bir hata oluştu. Lütfen tekrar deneyin.');
    });
}

$(document).ready(function() {
    $('#ihtiyacForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'save_data.php',
            type: 'POST',
            data: $('#ihtiyacForm').serialize(),
            dataType: 'json',
            success: function(response) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                const messageElement = $('#message');
                messageElement.text(response.message).show();
                if (response.status === 'success') {
                    messageElement.removeClass('alert-info alert-danger').addClass('alert-success');
                    // Başarılı kayıt sonrası index.php'ye yönlendir
                    setTimeout(function() {
                        window.location.href = '../index.php';
                    }, 2000);
                } else {
                    messageElement.removeClass('alert-success alert-danger').addClass('alert-info');
                }
                setTimeout(() => {
                    messageElement.fadeOut('slow');
                }, 5000);
                if (response.status === 'success') {
                    $('#ihtiyacForm')[0].reset();
                    if (marker) {
                        marker.setMap(null);
                        marker = null;
                    }
                    map.setCenter({ lat: 39.9334, lng: 32.8597 });
                    map.setZoom(7);
                }
            },
            error: function(xhr, status, error) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                const messageElement = $('#message');
                messageElement.text('Bir hata oluştu: ' + error).addClass('alert-danger').show();
                setTimeout(() => {
                    messageElement.fadeOut('slow');
                }, 5000);
            }
        });
    });
});

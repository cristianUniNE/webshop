<?php

class RegistryTableSeeder extends \Illuminate\Database\Seeder  {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('system_registries')->truncate();

		$system_registries = array(
			array('key' => 'abo','value' => '{"infos":{"logo":"unine.jpg","adresse":"<p>Facult\\u00e9 de droit<br>Avenue du 1er-Mars 26<br>CH-2000 Neuch\\u00e2tel<\\/p>"},"compte":"20-5711-2","message":"<ul><li>Le num\\u00e9ro de la pr\\u00e9sente facture est \\u00e0 rappeler dans toute correspondance.<\\/li><li>Merci de bien vouloir v\\u00e9rifier l\'exactitude de l\'adresse et nous communiquer toute modification.<\\/li><\\/ul>","days":30}'),
			array('key' => 'inscription','value' => '{"infos":{"logo":"unine.png","nom":"Secr\\u00e9tariat - Formation","email":"droit.formation@unine.ch","adresse":"<p>Avenue du 1er-Mars 26<br>CH-2000 Neuch\\u00e2tel<\\/p>","iban":"CH11 0900 0000 2000 4130 2","bic":"POFICHBEXXX","desistement":"<p>Les d\\u00e9sistements sont accept\\u00e9s sans frais jusqu\'\\u00e0 <strong>15 jours avant le s\\u00e9minaire<\\/strong>. Pass\\u00e9 ce d\\u00e9lai, le montant de l\'inscription n\'est plus rembours\\u00e9. Il est toutefois possible de vous faire remplacer.<\\/p>"},"qrcode":1,"restrict":1,"days":30,"messages":{"registered":"<p>Vous \\u00eates d\\u00e9j\\u00e0 inscrit \\u00e0 ce colloque.<\\/p>","pending":"<p>Vous avez des payements en attente, veuillez contacter le secr\\u00e9tariat: secretariat.droit@unine.ch<\\/p>"}}'),
			array('key' => 'shop','value' => '{"infos":{"logo":"facdroit.jpg","nom":"Facult\\u00e9 de droit","email":"droit.formation@unine.ch","adresse":"<p>Avenue du 1er-Mars 26 <br>2000 Neuch\\u00e2tel<\\/p>","telephone":"032 718 12 60","fax":"032 718 12 61 ","tva":"CHE 1234-345-456","taux_reduit":"2,5","taux_normal":8},"compte":{"livre":"20-4130-2"},"restrict":1,"days":40}')
		);

		// Uncomment the below to run the seeder
		DB::table('system_registries')->insert($system_registries);
	}

}

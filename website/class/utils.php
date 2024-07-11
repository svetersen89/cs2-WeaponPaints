<?php
class UtilsClass
{
    public static function skinsFromJson(): array
    {
        $skins = [];
        $json = json_decode(file_get_contents(__DIR__ . "/../data/skins.json"), true);
		$json2 = json_decode(file_get_contents(__DIR__ . "/../data/gloves.json"), true);

		
		foreach ($json2 as $glove) {
            $skins[(int) $glove['weapon_defindex']][(int) $glove['paint']] = [
				'weapon_name' => $glove['weapon_defindex'],
                'paint_name' => $glove['paint_name'],
                'image_url' => $glove['image'],
            ];
        }
		
        foreach ($json as $skin) {
            $skins[(int) $skin['weapon_defindex']][(int) $skin['paint']] = [
                'weapon_name' => $skin['weapon_name'],
                'paint_name' => $skin['paint_name'],
                'image_url' => $skin['image'],
            ];
        }

        return $skins;
    }

    public static function getWeaponsFromArray()
    {
        $weapons = [];
        $temp = self::skinsFromJson();

        foreach ($temp as $key => $value) {			
            if (key_exists($key, $weapons))
                continue;
			
			if (key_exists(0, $value))
			{	
				$weapons[$key] = [
					'weapon_name' => $value[0]['weapon_name'],
					'paint_name' => $value[0]['paint_name'],
					'image_url' => $value[0]['image_url'],
				];
			}
        }

        return $weapons;
    }

    public static function getKnifeTypes()
    {
        $knifes = [];
        $temp = self::getWeaponsFromArray();

        foreach ($temp as $key => $weapon) {
            if (!in_array($key, [
                    500,
                    514,
                    515,
                    503,
                    512,
                    505,
                    506,
                    509,
                    507,
                    526,
                    508,
                    520,
                    521,
                    517,
                    516,
                    525,
                    522,
                    518,
                    523,
                    519,
					530
                ]))
			{
                continue;
			}

            $knifes[$key] = [
                'weapon_name' => $weapon['weapon_name'],
                'paint_name' => rtrim(explode("|", $weapon['paint_name'])[0]),
                'image_url' => $weapon['image_url'],
            ];
			
			$knifes[0] = [
				'weapon_name' => "weapon_knife",
				'paint_name' => "Default knife",
				'image_url' => "https://raw.githubusercontent.com/Nereziel/cs2-WeaponPaints/main/website/img/skins/weapon_knife.png",
			];
        }

		ksort($knifes);		
        return $knifes;
    }
	
    public static function getGlovesTypes()
    {
        $gloves = [];
        $temp = self::getWeaponsFromArray();

        foreach ($temp as $key => $weapon) {
            if (
                !in_array($key, [
                    5027,
                    5030,
                    5031,
                    5032,
                    5033,
                    5034,
                    5035,
                    4725
                ])
            )
                continue;

            $gloves[$key] = [
                'weapon_name' => $weapon['weapon_name'],
                'paint_name' => rtrim(explode("|", $weapon['paint_name'])[0]),
                'image_url' => $weapon['image_url'],
            ];
            $gloves[0] = [
                'weapon_name' => "t_gloves",
                'paint_name' => "Default gloves",
                'image_url' => "",
            ];
        }

        ksort($gloves);
        return $gloves;
    }
	
	public static function getGlovesNameFromId(string $id)
	{
		if ($id == '4725')
		{
			return "studded_brokenfang_gloves";
		}
		else if ($id == '5027')
		{
			return "studded_bloodhound_gloves";
		}
		else if ($id == '5030')
		{
			return "sporty_gloves";
		}
		else if ($id == '5031')
		{
			return "slick_gloves";
		}
		else if ($id == '5032')
		{
			return "leather_handwraps";
		}
		else if ($id == '5033')
		{
			return "motorcycle_gloves";
		}
		else if ($id == '5034')
		{
			return "specialist_gloves";
		}
		else if ($id == '5035')
		{
			return "studded_hydra_gloves";
		}
		else 
		{
			return "t_gloves";
		}
	}

    public static function getSelectedSkins(array $temp)
    {
        $selected = [];

        foreach ($temp as $weapon) {
            $selected[$weapon['weapon_defindex']] =  [
                'weapon_paint_id' => $weapon['weapon_paint_id'],
                'weapon_seed' => $weapon['weapon_seed'],
                'weapon_wear' => $weapon['weapon_wear'],
            ];
        }

        return $selected;
    }
}

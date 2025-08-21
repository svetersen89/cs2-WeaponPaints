using System;
using System.Collections.Generic;
using System.IO;
using System.Text.Json;

namespace WeaponPaints
{
    // Resolves "7" -> weapon_ak47, "weapon_ak47" -> weapon_ak47, etc.
    public static class WeaponResolver
    {
        private static readonly Dictionary<int, string> _idToClass = new();      // numeric WeaponID -> classname
        private static readonly HashSet<string> _validClass = new(StringComparer.OrdinalIgnoreCase);

        // Call this in plugin Load() after gamedata has been copied.
        public static void Initialize(string gameDataPath /* e.g. addons/counterstrikesharp/gamedata/weaponpaints.json */)
        {
            _idToClass.Clear();
            _validClass.Clear();

            if (!File.Exists(gameDataPath))
                return; // fall back to minimal defaults if file missing

            using var s = File.OpenRead(gameDataPath);
            using var doc = JsonDocument.Parse(s);

            // The JSON is a large mapping; we only need the weapon classnames that appear as keys
            // and (optionally) any "id" fields if present for numeric lookup. If there is no id, we still accept the classname.
            foreach (var prop in doc.RootElement.EnumerateObject())
            {
                var key = prop.Name; // typically "weapon_ak47", "weapon_awp", ...
                if (key.StartsWith("weapon_", StringComparison.OrdinalIgnoreCase))
                    _validClass.Add(key);

                if (prop.Value.TryGetProperty("id", out var idEl) && idEl.ValueKind == JsonValueKind.Number)
                {
                    if (idEl.TryGetInt32(out var id))
                        _idToClass[id] = key;
                }
            }

            // Minimal fallbacks if json doesn’t expose numeric ids:
            EnsureId(7,  "weapon_ak47");
            EnsureId(9,  "weapon_awp");
            EnsureId(60, "weapon_m4a1_silencer");
            EnsureId(61, "weapon_usp_silencer");
        }

        private static void EnsureId(int id, string classname)
        {
            if (!_idToClass.ContainsKey(id)) _idToClass[id] = classname;
            _validClass.Add(classname);
        }

        public static bool TryResolve(string weaponArg, out string classname)
        {
            classname = string.Empty;

            // numeric?
            if (int.TryParse(weaponArg, out var id) && _idToClass.TryGetValue(id, out var byId))
            {
                classname = byId;
                return true;
            }

            // already an internal classname?
            if (weaponArg.StartsWith("weapon_", StringComparison.OrdinalIgnoreCase))
            {
                // accept any weapon_* that exists in the gamedata (future-proof)
                if (_validClass.Count == 0 || _validClass.Contains(weaponArg))
                {
                    classname = weaponArg;
                    return true;
                }
            }

            return false;
        }
    }
}

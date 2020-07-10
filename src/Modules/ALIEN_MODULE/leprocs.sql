DROP TABLE IF EXISTS leprocs;
CREATE TABLE `leprocs` (
	`profession` varchar(20) NOT NULL,
	`name` varchar(50) NOT NULL,
	`research_name` varchar(50) DEFAULT NULL,
	`research_lvl` int(11) NOT NULL,
	`proc_type` char(6) DEFAULT NULL,
	`chance` varchar(20) DEFAULT NULL,
	`modifiers` varchar(255) NOT NULL,
	`duration` varchar(20) NOT NULL,
	`proc_trigger` varchar(20) NOT NULL,
	`description` varchar(255) NOT NULL
);
INSERT INTO `leprocs` (`profession`, `name`, `research_name`, `research_lvl`, `proc_type`, `chance`, `modifiers`, `duration`, `proc_trigger`, `description`) VALUES
('Adventurer', 'Charring Blow', 'Exploration', 6, 'Type 2', '5%', 'Fight Target Hit Health Fire -633 .. -1220', '', 'Offensive', '633 .. 1220 fire AC damage'),
('Adventurer', 'Aesir Absorption', 'Exploration', 8, 'Type 1', '10%', 'Self Modify Add All Def. 50', '30s', 'Defensive', '+50 AAD, 30 second duration'),
('Adventurer', 'Ferocious hits', 'Game Warden', 1, 'Type 1', '5%', 'Self Modify +Damage 15', '30s', 'Offensive', 'Self +15 damage modifier, 30 second duration'),
('Adventurer', 'Skin Protection', 'Gunslinger', 3, 'Type 1', '10%', 'Self Modify ShieldAC 31, Self Modify AbsorbAC 150', '60s', 'Defensive', 'Self +31 shield AC and +150 Absorb AC, 60 second duration'),
('Adventurer', 'Machete Flurry', 'Keen Eyes', 7, 'Type 1', '5%', 'Self Modify +Damage 75', '60s', 'Offensive', 'Self +75 damage modifier, 60 second duration'),
('Adventurer', 'Healing Herbs', 'Keen Eyes', 10, 'Type 2', '5%', 'Self Hit Health 697 .. 1193', '', 'Offensive', 'Heals 697 .. 1193 max health'),
('Adventurer', 'Self Preservation', 'Safari Guide', 5, 'Type 1', '10%', 'Self Modify ShieldAC 52, Self Modify AbsorbAC 255', '60s', 'Defensive', 'Self +52 shield AC and +255 Absorb AC, 60 second duration'),
('Adventurer', 'Basic Dressing', 'Wilderness Lore', 1, 'Type 2', '5%', 'Self Hit Health 15 .. 25', '', 'Offensive', 'Heals 15 .. 25 max health'),
('Adventurer', 'Soothing Herbs', 'Wilderness Lore', 2, 'Type 1', '5%', 'Self Hit Health 186 .. 391', '', 'Offensive', 'Heals 186 .. 391 max health'),
('Adventurer', 'Machete Slice', 'Wilderness Survival', 3, 'Type 2', '5%', 'Fight Target Hit Health Fire -137 .. -350', '', 'Offensive', '137 .. 350 fire AC damage'),
('Adventurer', 'Restore Vigor', 'Wilderness Survival', 4, 'Type 2', '5%', 'Self Hit Health 356 .. 746', '', 'Offensive', 'Heals 356 .. 746 max health'),
('Adventurer', 'Combustion', 'Wilderness Survival', 10, 'Type 2', '5%', 'Fight Target Hit Health Fire -1294 .. -2415', '', 'Offensive', '1294 .. 2415 fire AC damage'),
('Agent', 'Minor Nanobot Enhance', 'Direct Action', 1, 'Type 1', '5%', 'Self Modify +Damage 15', '60s', 'Offensive', 'Self +15 damage modifier, 60 second duration'),
('Agent', 'Improved focus', 'Direct Action', 2, 'Type 2', '5%', 'Self Modify CriticalIncrease 15', '15s', 'Offensive', 'Self 15% critical increase, 15 second duration'),
('Agent', 'No Escape!', 'End Certification', 6, 'Type 1', '5%', 'Fight Target Restrict Action Movement, 6s delay', '6s', 'Offensive', 'Fight Target root, 6 second duration'),
('Agent', 'Laser Aim', 'End Certification', 8, 'Type 2', '5%', 'Self Modify CriticalIncrease 30', '60s', 'Offensive', 'Self +30% critical increase, 60 second duration'),
('Agent', 'Cell Killer', 'Fitness', 3, 'Type 2', '5%', 'Fight Target Hit Health Melee 75, 10 hits, 1s delay', '10s', 'Offensive', '75 melee AC damage, 10 hits every 1 seconds'),
('Agent', 'Intense Metabolism', 'Intuition', 3, 'Type 1', '5%', 'Self Modify NanoC. Init 250', '60s', 'Offensive', 'Self +250 NanoC. Init, 60 second duration'),
('Agent', 'Plasteel Piercing Rounds', 'Intuition', 4, 'Type 2', '5%', 'Self Modify +Damage 75', '60s', 'Offensive', 'Self +75 damage modifier, 60 second duration'),
('Agent', 'Notum-Charged Rounds', 'Intuition', 10, 'Type 2', '5%', 'Self Modify +Damage 200', '60s', 'Offensive', 'Self +200 damage modifier, duration 60 seconds'),
('Agent', 'Nano-Enhanced Targeting', 'Marksmanship', 5, 'Type 2', '5%', 'Self Modify CriticalIncrease 22', '15s', 'Offensive', 'Self +22% critical increase, 15 second duration'),
('Agent', 'Broken Ankle', 'Stealth', 1, 'Type 2', '5%', 'Fight Target Restrict Action Movement', '3s', 'Offensive', 'Fight Target root, 3 second duration'),
('Agent', 'Disable Cuffs', 'Threat Assessment', 7, 'Type 1', '10%', 'Self Remove roots/snares, Resist root/snares 20%', '15s', 'Offensive', 'Self remove roots and snares, 20% root/snare resist, 15 seconds'),
('Agent', 'Grim Reaper', 'Threat Assessment', 10, 'Type 1', '5%', 'Fight Target Hit Health Melee 500, 10 hits, 1s delay', '', 'Offensive', '500 melee AC damage, 10 hits every 1 seconds'),
('Bureaucrat', 'Inflation Adjustment', 'Process Theory', 1, 'Type 2', '5%', 'Self Modify Nano attack damage modifier 10%', '60s', 'Offensive', 'Self +10% nano damage modifier, 60 second duration'),
('Bureaucrat', 'Papercut', 'Market Awareness', 1, 'Type 2', '5%', 'Fight Target Hit Health Cold -10 .. -23', '', 'Offensive', '10 .. 23 cold AC damage'),
('Bureaucrat', 'Social Services', 'Hostile Negotiations', 5, 'Type 1', '5%', 'Fight Target Restrict Action Movement', '6s', 'Offensive', 'Fight Target root, 6 second duration'),
('Bureaucrat', 'Lost Paperwork', 'Professional Development', 4, 'Type 2', '5%', 'Fight Target Hit Health Melee -264 .. -532', '', 'Offensive', '264 .. 532 melee AC damage'),
('Bureaucrat', 'Next Window Over', 'Professional Development', 3, 'Type 1', '5%', 'Self Hit Nano 10%', '', 'Offensive', 'Self, fills 10% of nano pool'),
('Bureaucrat', 'Deflation', 'Executive Decisions', 3, 'Type 2', '5%', 'Self Modify Nano attack damage 25%', '45s', 'Offensive', 'Self +25% nano damage modifier, 45 second duration'),
('Bureaucrat', 'Wait In That Queue', 'Process Theory', 2, 'Type 1', '5%', 'Fight Target Modify Run speed -600', '15s', 'Offensive', 'Fight Target -600 runspeed, 15 second duration, unremovable'),
('Bureaucrat', 'Forms in Triplicate', 'Human Resources', 6, 'Type 1', '5%', 'Self Hit Nano 20%', '', 'Offensive', 'Self fills 20% of nano pool'),
('Bureaucrat', 'Wrong Window', 'Human Resources', 8, 'Type 2', '5%', 'Self Modify Nano attack damage 50%', '30s', 'Offensive', 'Self +50% nano damage modifier, 30 second duration'),
('Bureaucrat', 'Mobility Embargo', 'Professional Development', 10, 'Type 2', '5%', 'AOE 10m Restrict Action Movement', '8s', 'Offensive', 'Fight Target AOE root, 10 meter radius, 8 second duration'),
('Bureaucrat', 'Tax Audit', 'Team Building', 7, 'Type 2', '5%', 'Fight Target Hit Health Energy -1600 .. -3750', '', 'Offensive', '1600 .. 3750 energy AC damage, 3574 taunt'),
('Bureaucrat', 'Please Hold', 'Team Building', 10, 'Type 1', '5%', 'Fight Target Modify Run speed -1500', '30s', 'Offensive', 'Fight Target -1500 runspeed, 30 second duration, 2% chance to break on hit, 7% chance to break on nano damage, 1% chance to break on debuff'),
('Doctor', 'Muscle Memory', 'Aggressive Surgery', 5, 'Type 1', '5%', 'Self Nano Init Buff 250', '60s', 'Offensive', 'Self +250 nano initiative buff, 60 second duration'),
('Doctor', 'Antiseptic', 'Bedside Manner', 8, 'Type 1', '5%', 'Healing 1133 .. 1533', '', 'Offensive', 'Heals 1133 .. 1533 max health'),
('Doctor', 'Healing Care', 'Bedside Manner', 6, 'Type 2', '10%', 'Healing (Team) 434 .. 820', '', 'Defensive', 'Heals team 434 .. 820 max health'),
('Doctor', 'Anesthetic', 'Diagnosis', 3, 'Type 2', '5%', 'Self HealEff +15%', '60s', 'Offensive', 'Self +15% Heal Efficiency for 60s'),
('Doctor', 'Blood Transfusion', 'Internship', 3, 'Type 1', '5%', 'Healing 327 .. 551', '', 'Offensive', 'Heals 327 .. 551 max health'),
('Doctor', 'Pathogen', 'Internship', 4, 'Type 2', '5%', 'DOT 1 3375 Poisondamage (15x225 every 2sec)', '30s', 'Offensive', '225 poison AC damage, 15 hits every 2 seconds'),
('Doctor', 'Massive Vitae Plan', 'Internship', 10, 'Type 2', '5%', 'Self HealEff 25%', '60', 'Offensive', 'Self +25% Heal Efficiency for 60s'),
('Doctor', 'Astringent', 'Rehabilitation', 2, 'Type 2', '5%', 'Init Debuff 350', '20s', 'Offensive', 'Fight Target -350 initiative debuff, 20 second duration, 15% chance to break on hit, 20% chance to break on nano damage, 20% chance to break on debuff'),
('Doctor', 'Inflammation', 'Rehabilitation', 1, 'Type 2', '5%', 'DOT 300 Poisondamage (20x15 every 2sec)', '30s', 'Offensive', '20 poison AC damage, 15 hits every 2 seconds'),
('Doctor', 'Dangerous Culture', 'Toxicology', 10, 'Type 1', '5%', 'DOT 11250 Poisondamage (15x750 every 2sec)', '30s', 'Offensive', '750 poison AC damage, 15 hits every 2 seconds'),
('Doctor', 'Anatomic Blight', 'Toxicology', 7, 'Type 2', '5%', 'Init Debuff 569', '', 'Offensive', 'Fight Target -569 initiative debuff, 60 second duration, 10% chance to break on hit, 10% chance to break on nano damage, 10% chance to break on debuff'),
('Doctor', 'Restrictive Bandaging', 'Underground Doctor', 1, 'Type 1', '5%', 'Healing 21 .. 37', '', 'Offensive', 'Heals 21 .. 37 max health'),
('Enforcer', 'Vortex of Hate', 'Anger Management', 10, 'Type 1', '5%', 'AOE Taunt 11k-13k, Self HOT 224 x10, 2s delay', '20s', 'Offensive', 'AOE Taunt 11k-13k, Heal 224 x10, 2s delay'),
('Enforcer', 'Vile Rage', 'Anger Management', 3, 'Type 1', '5%', '+350 Runspeed, +200 NR, +250 Inits', '60s', 'Offensive', '+350 runspeed, +200 nano resist, +250 initiatives, 60 second duration'),
('Enforcer', 'Tear Ligaments', 'Anger Management', 4, 'Type 1', '5%', '+170 Dmg, +70 AAO', '60s', 'Offensive', '+70 AAO, +170 damage modifier, 60 second duration'),
('Enforcer', 'Shrug Off Hits', 'Brawlers Sense', 2, 'Type 2', '5%', 'Absorbshield 280', '60s', 'Offensive', '280 Absorb AC buff, 60 second duration'),
('Enforcer', 'Bust Kneecaps', 'Brawlers Sense', 1, 'Type 2', '5%', '+27 Dmg, +19 AAO', '42s', 'Offensive', '+19 AAO, +27 damage modifier, 42 second duration'),
('Enforcer', 'Inspire Rage', 'Brutality', 5, 'Type 1', '5%', 'Taunt 1600', '', 'Offensive', 'Fight Target 1600 taunt'),
('Enforcer', 'Inspire Ire', 'Endurance', 6, 'Type 2', '5%', 'Taunt 4750', '', 'Offensive', 'Fight Target 4750 taunt'),
('Enforcer', 'Shield of the ogre', 'Endurance', 8, 'Type 1', '5%', 'Absorbshield 745', '60s', 'Offensive', '745 Absorb AC buff, 60 second duration'),
('Enforcer', 'Raging Blow', 'Flexibility', 10, 'Type 1', '5%', '+255 Dmg, +111 AAO', '60s', 'Offensive', '+111 AAO, +255 damage modifier, 60 second duration'),
('Enforcer', 'Violation Buffer', 'Flexibility', 7, 'Type 2', '5%', 'Damageshield +479 Max HP +75 Shield damage +240 Energy AC, Heal 479', '60s', 'Offensive', '+479 max health, +75 shield AC, Heal 479, 60 second duration'),
('Enforcer', 'Ignore Pain', 'Hard Labor', 1, 'Type 2', '5%', 'Damageshield +25 Max HP +10 Shield damage, self heal 25', '60s', 'Offensive', '+25 max health, +10 shield AC, Heal 25, 60 second duration'),
('Enforcer', 'Air of hatred', 'Kneecapping', 3, 'Type 1', '5%', '20m AOE taunt 5k-7k, self Heal 79 x10, 2s delay', '20s', 'Offensive', 'AOE Taunt 5k-7k, Heal 79 x10, 2s delay, 20 second duration'),
('Engineer', 'Drone Explosives', 'Combat Applications', 5, 'Type 2', '5%', 'Fight Target Hit 497 .. 1016 Projectiledamage', '', 'Offensive', '497 .. 1016 projectile AC damage'),
('Engineer', 'Destructive Signal', 'Ergonomics', 3, 'Type 1', '5%', 'Init Buff +80, +20 Dmg', '60s', 'Offensive', '+80 All Inits, +20 Dmg, 60 second duration'),
('Engineer', 'Endure Barrage', 'Ergonomics', 4, 'Type 1', '5%', 'AC Buff +550', '60s', 'Offensive', '+550 AC, 60 second duration'),
('Engineer', 'Assault Force Relief', 'Ergonomics', 10, 'Type 2', '5%', 'AC Buff (Team) +2500', '60s', 'Offensive', 'Team +2500 AC, 60 second duration'),
('Engineer', 'Cushion Blows', 'Mechanical Assistance', 1, 'Type 1', '5%', 'Damageshield +10, +40 Melee AC', '60s', 'Offensive', '+10 shield AC, +40 melee AC, 60 second duration'),
('Engineer', 'Congenial Encasement', 'Mechanical Assistance', 2, 'Type 2', '5%', 'Reflectshield +13%, Max Reflected Damage +7', '60s', 'Offensive', '+13% reflect modifier, +7 reflect damage, 60 second duration'),
('Engineer', 'Personal Protection', 'Military Hardware', 1, 'Type 2', '5%', 'AC Buff +130', '60s', 'Offensive', '+130 AC, 60 second duration'),
('Engineer', 'Energy Transfer', 'Practical Application', 6, 'Type 1', '5%', 'Damageshield +75', '60s', 'Offensive', '+75 shield AC, 60 second duration'),
('Engineer', 'Reactive Armor', 'Practical Application', 8, 'Type 1', '5%', 'Absorbshield 675', '60s', 'Offensive', '675 Absorb AC buff, 60 second duration'),
('Engineer', 'Splinter Preservation', 'Process Refinement', 3, 'Type 1', '5%', 'Absorbshield 375', '60s', 'Offensive', '375 Absorb AC buff, 60 second duration'),
('Engineer', 'Drone Missiles', 'Serendipity', 10, 'Type 2', '5%', 'Fight Target Hit 1575 .. 3211', '', 'Offensive', '1575 .. 3211 energy AC damage'),
('Engineer', 'Destructive Theorem', 'Serendipity', 7, 'Type 1', '5%', 'Init Buff +150, +35 Dmg', '60s', 'Offensive', '+150 all inits, +35 Dmg, 60 second duration'),
('Fixer', 'Dirty Tricks', 'Acquisition', 6, 'Type 1', '5%', 'Dodge-Rng +100', '60s', 'Offensive', '+100 Dodge-Rng, 60 second duration'),
('Fixer', 'Contaminated Bullets', 'Cunning', 1, 'Type 2', '5%', '+15 Dmg', '60s', 'Offensive', '+15 Dmg, 60 second duration'),
('Fixer', 'Fish In A Barrel', 'Cunning', 2, 'Type 1', '5%', 'Evade Debuff -85', '60s', 'Offensive', 'Fight Target -85 Duck-Exp, Dodge-Rng and Evade-ClsC, 60 second duration'),
('Fixer', 'Luck''s Calamity', 'Cunning', 8, 'Type 1', '5%', 'Evade Debuff -170', '60s', 'Offensive', 'Fight Target -170 Duck-Exp, Dodge-Rng and Evade-ClsC, 60 second duration'),
('Fixer', 'Underground Sutures', 'Fallback Plan', 1, 'Type 2', '5%', 'Self HOT 15 .. 18 x12, 5s delay', '60s', 'Offensive', 'Heal 15 .. 18 x12, 5s delay'),
('Fixer', 'Fighting Chance', 'Fallback Plan', 5, 'Type 2', '5%', '+50 Dmg', '60s', 'Offensive', '+50 Dmg, 60 second duration'),
('Fixer', 'Backyard Bandages', 'Insurance', 6, 'Type 2', '5%', 'Self HOT 362 .. 370 x180, 10s delay', '60s', 'Offensive', 'Heal 362 .. 370 x180, 10s delay, 60 second duration'),
('Fixer', 'Escape The System', 'Respectable Businessman', 4, 'Type 1', '10%', 'Root reducer -45s', '', 'Offensive', 'Self reduce root 45s'),
('Fixer', 'Bootleg Remedies', 'Respectable Businessman', 10, 'Type 2', '5%', 'Self HOT 406 .. 439 x180, 10s delay', '60s', 'Offensive', 'Heal 406 .. 439 x180, 10s delay, 60 second duration'),
('Fixer', 'Bending The Rules', 'Subtlety', 7, 'Type 2', '5%', '+85 Dmg', '60s', 'Offensive', '+85 Dmg, 60 second duration'),
('Fixer', 'Slip Them A Mickey', 'Subtlety', 10, 'Type 2', '5%', '+130 Dmg', '60s', 'Offensive', '+130 Dmf Buff, 60 second duration'),
('Fixer', 'Intense Metabolism', 'Smuggler''s Sense', 3, 'Type 1', '5%', 'NanoC Init +250', '60s', 'Offensive', '+250 NanoC Init, 60 second duration'),
('Keeper', 'Righteous Strike', 'Wisdom', 1, 'Type 1', '5%', '+20 Dmg', '60s', 'Offensive', '+20 Dmg, 60 second duration'),
('Keeper', 'Faithful Reconstruction', 'Virtue', 1, 'Type 2', '5%', 'Team Hit Health 42 .. 53', '', 'Offensive', 'Team heal 42 .. 53'),
('Keeper', 'Eschew the Faithless', 'Wisdom', 2, 'Type 1', '5%', 'Self Evade-ClsC +50, Dodge-Rng +14, Duck-Exp +14', '60s', 'Offensive', '+50 Evade-ClsC, +14 Dodge-Rng and Duck-Exp, 60 second duration'),
('Keeper', 'Virtuous Reaper', 'Champion', 6, 'Type 1', '5%', 'Dmg (Team) +90', '60s', 'Offensive', 'Team +90 Dmg, 60 second duration'),
('Keeper', 'Symbiotic Bypass', 'Champion', 8, 'Type 1', '5%', 'Team +140 Evade-ClsC, +40 Dodge-Rng, +40 Duck-Exp', '60s', 'Offensive', 'Team +140 Evade-ClsC, +40 Dodge-Rng and Duck-Exp, 60 second duration'),
('Keeper', 'Ambient Purification', 'Exemplar', 7, 'Type 2', '5%', 'Team Heal 481 .. 948', '', 'Offensive', 'Team heal 481 .. 948 health'),
('Keeper', 'Righteous Smite', 'Exemplar', 10, 'Type 1', '5%', 'Dmg (Team) +200', '60s', 'Offensive', 'Team +200 Dmg, 60 second duration'),
('Keeper', 'Subjugation', 'Judgement', 3, 'Type 2', '5%', 'Team AAO +20, AAD +45', '60s', 'Offensive', 'Team AAO +20, AAD +45, 60 seconds'),
('Keeper', 'Ignore the Unrepentant', 'Judgement', 4, 'Type 1', '5%', '+110 Evade-ClsC, +30 Dodge-Rng, +30 Duck-Exp', '60s', 'Offensive', '+110 Evade-ClsC, +30 Dodge-Rng and Duck-Exp, 60 second duration'),
('Keeper', 'Honor Restored', 'Judgement', 10, 'Type 2', '5%', 'Team AAO +50, AAD +120', '', 'Offensive', 'Team AAO +50 AAD +120, 60 seconds'),
('Keeper', 'Pure Strike', 'Loyalty', 3, 'Type 1', '5%', '+65 Dmg', '60s', 'Offensive', '+65 Dmg, 60 second duration'),
('Keeper', 'Benevolent Barrier', 'Paragon', 5, 'Type 2', '5%', 'Reflect Shield +4%', '600s', 'Offensive', '+4% reflect AC, 10 minute duration'),
('Martial Artist', 'Absolute Fist', 'Alacrity', 10, 'Type 1', '5%', '+111 Dmg', '60s', 'Offensive', '+111 damage buff 60 second duration'),
('Martial Artist', 'Strengthen Spirit', 'Alacrity', 3, 'Type 1', '5%', '+269 Melee/ma AC, +229 Other AC', '60s', 'Offensive', '+269 Melee/ma AC, +229 Other AC, 60 second duration'),
('Martial Artist', 'Healing Meditation', 'Cognizance', 5, 'Type 2', '5%', 'Healing 443 .. 981', '', 'Offensive', 'Heals 443 .. 981 max health'),
('Martial Artist', 'Debilitating Strike', 'Cognizance', 6, 'Type 2', '5%', 'Crit Increase +19%', '60s', 'Offensive', '+19% critical increase, 60 second duration'),
('Martial Artist', 'Medicinal Remedy', 'Empathy', 1, 'Type 2', '5%', 'Healing 34 .. 59', '', 'Offensive', 'Heals 34 .. 59 max health'),
('Martial Artist', 'Strengthen Ki', 'Intuition', 8, 'Type 1', '5%', '+40 Strength, +676 Melee/ma AC, +574 Other AC', '60s', 'Offensive', '+40 Strength, +574 AC, +676 Melee/ma AC, 60 second duration'),
('Martial Artist', 'Smashing Fist', 'Meditation', 4, 'Type 1', '5%', '+63 Dmg', '60s', 'Offensive', '+63 Dmg buff, 60 second duration'),
('Martial Artist', 'Self Reconstruction', 'Meditation', 10, 'Type 2', '5%', 'Healing 980 .. 1803', '', 'Offensive', 'Heals 980 .. 1803 health'),
('Martial Artist', 'Attack Ligaments', 'Nimble', 2, 'Type 2', '5%', 'Crit Increase +8%', '60s', 'Offensive', '+8% critical increase, 60 second duration'),
('Martial Artist', 'Stinging Fist', 'Reflex', 1, 'Type 1', '5%', '+19 Dmg', '60s', 'Offensive', '+19 Dmg buff, 60 second duration'),
('Martial Artist', 'Disrupt Ki', 'Reflex', 7, 'Type 1', '5%', 'Evade Buff +85', '60s', 'Offensive', '+85 Duck-Exp, Dodge-Rng and Evade-ClsC, 60 second duration'),
('Meta-Physicist', 'Thoughtful Means', 'Angst', 5, 'Type 1', '5%', 'Fight Target: Nano Cost +25%', '60s', 'Offensive', 'Increases nano cost of the Fight Target by 25%, 60 second duration'),
('Meta-Physicist', 'Ego Strike', 'Foresight', 6, 'Type 2', '5%', 'Fight Target Hit 802 .. 1468 Cold damage', '', 'Offensive', 'Fight Target 802 .. 1486 cold AC damage'),
('Meta-Physicist', 'Anticipated Evasion', 'Foresight', 8, 'Type 1', '5%', 'Evade Buff +250', '60s', 'Offensive', '+250 Duck-Exp, Dodge-Rng and Evade-ClsC, 60 second duration'),
('Meta-Physicist', 'Sow Despair', 'Jealousy', 1, 'Type 2', '5%', 'Fight Target Hit 30 .. 65 Disease damage', '', 'Offensive', 'Fight Target 30 .. 65 disease AC damage'),
('Meta-Physicist', 'Regain Focus', 'Perseverences', 3, 'Type 1', '5%', 'Evade Buff +100', '60s', 'Offensive', '+100 Duck-Exp, Dodge-Rng  and Evade-ClsC, 60 second duration'),
('Meta-Physicist', 'Mind Wail', 'Perseverences', 4, 'Type 2', '5%', 'Fight Target Hit 314 .. 699 Cold damage', '', 'Offensive', 'Fight Target  314 .. 699 cold AC damage'),
('Meta-Physicist', 'Nanobot Contingent Arrest', 'Perseverences', 10, 'Type 1', '5%', 'Fight Target: -750 NanoC. Init, %Add nano cost +100%, Decrease Nano cast interrupt -25%', '60s', 'Offensive', 'Fight Target -750 NanoC Init, add nano cost 100%, incrase interrupt chance by 25%, 60 second duration'),
('Meta-Physicist', 'Diffuse Rage', 'Spatial Awareness', 1, 'Type 2', '5%', 'Fight Target: Dmg Debuff -7, -35 Inits', '60s', 'Offensive', 'Fight Target -7 damage modifier, -35 inits, 60 second duration'),
('Meta-Physicist', 'Economic Nanobot Use', 'Spatial Awareness', 2, 'Type 1', '5%', 'Nano Cost -12%', '60s', 'Offensive', '-12% Nano Cost, 60 second duration'),
('Meta-Physicist', 'Super-Ego Strike', 'Sympathy', 10, 'Type 2', '5%', 'Fight Target Hit 1500 .. 3000 Cold damage', '', 'Offensive', 'Fight Target 1500 .. 3000 cold AC damage'),
('Meta-Physicist', 'Suppress Fury', 'Sympathy', 7, 'Type 2', '5%', 'Fight Target Dmg -75, -261 inits', '60s', 'Offensive', 'Fight Target -75 Dmg, -261 inits, 60 second duration'),
('Meta-Physicist', 'Sow Doubt', 'Trauma', 3, 'Type 2', '5%', 'Fight Target Dmg -35, -156 inits', '60s', 'Offensive', 'Fight Target -35 Dmg, -156 inits, 60 second duration'),
('Nano-Technician', 'Source Tap', 'Combat Execution', 3, 'Type 1', '10%', 'Self Nano-HOT 1224 (12x102 every 5sec)', '60s', 'Defensive', '+102 nano points, 12 hits, every 5 seconds, 60 second duration'),
('Nano-Technician', 'Unstable Library', 'Discipline', 1, 'Type 2', '10%', 'AC Buff +31, +50 Max HP, +32 NR', '60s', 'Defensive', '+31 AC, +50 Max Health +32 Nano Resist, 60 second duration'),
('Nano-Technician', 'Powered Nano Fortress', 'Discipline', 5, 'Type 2', '10%', 'AC Buff +167, +246 Max HP, +111 NR', '60s', 'Defensive', '+167 AC, +246 Max Health, +111 Nano Resist, 60 second duration'),
('Nano-Technician', 'Thermal Reprieve', 'Intellectual Refinement', 9, 'Type 1', '10%', 'ReflectAC +10% MaxReflect+10 Dmg', '60s', 'Defensive', '+10% ReflectAC, +10 MaxReflectDmg, 60 second duration'),
('Nano-Technician', 'Looping Service', 'Intellectual Refinement', 6, 'Type 2', '10%', 'Absorbshield 680', '60s', 'Defensive', '680 Absorb AC buff, 60 second duration'),
('Nano-Technician', 'Harvest Energy', 'Nano Theory', 7, 'Type 1', '10%', 'Self Nano-HOT 5220 (12x435 every 5sec)', '60s', 'Defensive', '+435 nano points, 12 hits, every 5 seconds, 60 second duration'),
('Nano-Technician', 'Optimized Library', 'Nano Theory', 10, 'Type 2', '10%', 'AC Buff +331, +350 Max HP, +140 NR', '60s', 'Defensive', '+331 AC, +350 Max Health, +140 Nano Resist, 60 second duration'),
('Nano-Technician', 'Circular Logic', 'Particle Physics', 1, 'Type 1', '10%', 'Self Nano-HOT 60 (12x5 every 5sec)', '60s', 'Defensive', '+5 nano points, 12 hits, every 5 seconds, 60 second duration'),
('Nano-Technician', 'Increase Momentum', 'Particle Physics', 2, 'Type 2', '10%', 'NanoC init +200', '60s', 'Defensive', '+200 NanoC init, 60 second duration'),
('Nano-Technician', 'Layered Amnesty', 'Practical Use', 4, 'Type 1', '10%', 'ReflectAC +4%', '60s', 'Defensive', '+4% ReflectAC, 60 second duration '),
('Nano-Technician', 'Accelerated Reality', 'Practical Use', 10, 'Type 2', '10%', 'NanoC init +600', '60s', 'Defensive', '+600 NanoC init, 60 second duration'),
('Shade', 'Drain Essence', 'Ambushing', 5, 'Type 1', '5%', 'Fight Target Hit 320 Energy damage, Heal 310', '', 'Offensive', 'Fight Target -382 energy AC damage, heals 310 health'),
('Shade', 'Siphon Being', 'Assassin''s Awareness', 8, 'Type 1', '5%', 'Fight Target Hit 580 Energy damage, Heal 577', '', 'Offensive', 'Fight Target -580 energy AC damage, heals 577 health'),
('Shade', 'Shadowed Gift', 'Assassin''s Awareness', 6, 'Type 1', '5%', 'DOT 975 Poison damage (5x195 hits every 1 sec)', '6s', 'Offensive', '195 poison AC damage, 5 hits, every 1 second, 6 second duration'),
('Shade', 'Blackheart', 'Honed Senses', 10, 'Type 2', '5%', 'Fight Target Hit 767 Melee/ma damage', '', 'Offensive', 'Fight Target -767 Melee/ma AC damage'),
('Shade', 'Twisted Caress', 'Honed Senses', 7, 'Type 2', '5%', 'Fight Target Hit 550 Melee/ma damage', '', 'Offensive', 'Fight Target -550 Melee/ma AC damage'),
('Shade', 'Devious Spirit', 'Killing Blows', 1, 'Type 2', '5%', 'Fight Target Hit 23 Melee/ma damage', '', 'Offensive', 'Fight Target -23 Melee/ma AC damage'),
('Shade', 'Misdirection', 'Killing Blows', 2, 'Type 2', '5%', 'Evade Buff Evade-ClsC +40, Duck-Exp 25, Dodge-Rng +25', '60s', 'Offensive', '+40 Evade-ClsC, +25 Duck-Exp and Dodge-Rng, 60 second duration'),
('Shade', 'Sap Life', 'Lithe', 1, 'Type 1', '5%', 'Fight Target Hit 17 Energy damage, Heal 7', '', 'Offensive', 'Fight Target -17 Energy AC damage, heals 7 health'),
('Shade', 'Toxic Confusion', 'Malicious Forethought', 3, 'Type 1', '5%', 'DOT 425 Poisondamage (5x85 hits every 1sec)', '6s', 'Offensive', '85 poison AC damage, 5 hits every 1 second, 6 second duration'),
('Shade', 'Elusive Spirit', 'Malicious Forethought', 4, 'Type 1', '5%', 'Evade Buff Evade-ClsC +56, Duck-Exp +32, Dodge-Rng +32', '60s', 'Offensive', '+56 Evade-ClsC, +32 Duck-Exp and Dodge-Rng, 60 second duration'),
('Shade', 'Blackened Legacy', 'Malicious Forethought', 10, 'Type 1', '5%', 'Evade Buff Evade-ClsC +100, Duck-Exp +50 Dodge-Rng +50', '60s', 'Offensive', '+100 Evade-ClsC, +50 Duck-Exp and Dodge-Rng, 60 second duration'),
('Shade', 'Concealed Surprise', 'Stiletto Mastery', 3, 'Type 2', '5%', 'Fight Target Hit 234 Melee/ma damage', '', 'Offensive', 'Fight Target -234 Melee/ma AC damage'),
('Soldier', 'Successful Targeting', 'Classified Ops', 1, 'Type 1', '5%', 'Buff AAO +23', '60s', 'Offensive', '+23 AAO, 60 second duration'),
('Soldier', 'Shoot Artery', 'Combat Sense', 1, 'Type 2', '5%', '+15 Dmg', '60s', 'Offensive', '+15 Dmg, 60 second duration'),
('Soldier', 'Deep Six Initiative', 'Combat Sense', 2, 'Type 2', '5%', 'Init Buff +50', '60s', 'Offensive', '+50 inits, 60 second duration'),
('Soldier', 'Reconditioned', 'Force Recon', 5, 'Type 1', '5%', 'Self Buff +361 Max HP, Self HOT 650 (13x50 every 5s)', '60s', 'Offensive', '+361 Max Health, +50 HP, 13 hits, every 5 seconds, 60 second duration'),
('Soldier', 'Concussive Shot', 'Forward Observer', 3, 'Type 1', '5%', '+35 Dmg', '60s', 'Offensive', '+35 Dmg, 60 second duration'),
('Soldier', 'Gear Assault Absorption', 'Forward Observer', 4, 'Type 2', '5%', 'MaxReflect+25 Dmg', '60s', 'Offensive', 'Increases damage reflected by 25, 60 second duration'),
('Soldier', 'Fuse Body Armor', 'Forward Observer', 10, 'Type 2', '5%', 'MaxReflect+75 Dmg', '60s', 'Offensive', 'Increases damage reflected by 75, 60 second duration'),
('Soldier', 'Emergency Bandages', 'Marksmanship', 3, 'Type 1', '5%', 'Self Buff +200 Max HP, Self HOT 325 (13x25 every 5s)', '60s', 'Offensive', '+200 Max Health, +25 HP, 13 hits, every 5 seconds, 60 second duration'),
('Soldier', 'Graze Jugular Vein', 'Strategic Planning', 7, 'Type 2', '5%', '+70 Dmg', '60s', 'Offensive', '+70 Dmg, 60 second duration'),
('Soldier', 'Furious Ammunition', 'Strategic Planning', 10, 'Type 1', '5%', '+99 Dmg', '60s', 'Offensive', '+99 Dmg, 60 second duration'),
('Soldier', 'Fight Target Acquired', 'Sweep and Clear', 6, 'Type 1', '5%', 'AAO +35', '60s', 'Offensive', '+35 AAO, 60 second duration'),
('Soldier', 'On The Double', 'Sweep and Clear', 8, 'Type 2', '5%', 'Init Buff +150', '60s', 'Offensive', '+150 inits, 60 second duration'),
('Trader', 'Escrow', 'Aggressive Pricing', 3, 'Type 2', '5%', 'Nanodrain 798 Drain (6x133 every 5sec) 600 Gain (6x100 every 5sec)', '30s', 'Offensive', 'Fight Target -133 nano points, self +100 nano points, 6 hits every 5 seconds, 30 second duration'),
('Trader', 'Unexpected Bonus', 'Door-To-Door Salesman', 3, 'Type 1', '5%', 'Fight Target Hit 300 Energy damage, Heal 222', '', 'Offensive', 'Fight Target -300 energy AC damage, heals 222 max health'),
('Trader', 'Unforgiven Debts', 'Door-To-Door Salesman', 4, 'Type 1', '5%', 'Skilldrain 136 Weapon- and Nanoskills, 68 AAO (10s, PvM only)', '30s', 'Offensive', 'Fight Target -136 weapon and nanoskills, -68 AAO, 10 second duration, self +136 weapon and nanoskills, +68 AAO, 30 second duration'),
('Trader', 'Debt Collection', 'Door-To-Door Salesman', 10, 'Type 1', '5%', 'Fight Target Hit 1100 .. 1200 Energy damage, self 1100 .. 1300 Healing', '', 'Offensive', 'Fight Target -1100 to -1200 energy AC damage, heals 1100 .. 1300 health'),
('Trader', 'Exchange Product', 'Eye for a Deal', 6, 'Type 1', '5%', 'Fight Target Hit 990 Energy damage, Heal 997', '', 'Offensive', 'Fight Target -990 energy AC damage, heals 997 health'),
('Trader', 'Unopened Letter', 'Eye for a Deal', 8, 'Type 2', '5%', 'Fight Target -2098 AC, Self +2067 AC', '60s', 'Offensive', 'Fight Target -2098 AC, Self +2067 AC, 60 second duration'),
('Trader', 'Rigid Liquidation', 'Fast Talk', 7, 'Type 2', '5%', 'Fight Target Hit -1842 Nano Points (6x307 every 5s), Self Nano Points +1626 (6x271 every 5sec)', '30s', 'Offensive', 'Fight Target -307 nano points, self +271 nano points, 6 hits every 5 seconds, 30 second duration'),
('Trader', 'Accumulated Interest', 'Fast Talk', 10, 'Type 1', '5%', 'Skilldrain 204 Weapon- and Nanoskills, 102 AAO (10s, PvM only)', '30s', 'Offensive', 'Fight Target -204 weapon and nanoskills, -102 AAO, 10 second duration, self +204 weapon and nanoskills, +102 AAO, 30 second duration'),
('Trader', 'Deplete Assets', 'Hostile Takeover', 5, 'Type 2', '5%', 'Fight Target -1449 AC, Self +1394 AC', '60s', 'Offensive', 'Fight Target -1449 AC, self +1394 AC, 60 second duration'),
('Trader', 'Rebate', 'Sensible Investment', 1, 'Type 1', '5%', 'Fight Target Hit 43 Energy damage, Heal 18', '', 'Offensive', 'Fight Target -43 Energy AC damage, heals 18 health'),
('Trader', 'Refinance Loans', 'Sensible Investment', 2, 'Type 2', '5%', 'Fight Target -200 AC, Fight Target''s Fight Target +200 AC', '60s', 'Offensive', 'Fight Target -200 AC, Fight Target''s Fight Target +200 AC, 60 second duration'),
('Trader', 'Payment Plan', 'Sensitive Negotiations', 1, 'Type 2', '5%', 'Skilldrain 9 Weapon- and Nanoskills, 5 AAO (10s, PvM only)', '30s', 'Offensive', 'Fight Target -9 weapon and nanoskills, -5 AAO, 10 second duration, self +9 weapon and nanoskills, +5 AAO, 30 second duration');

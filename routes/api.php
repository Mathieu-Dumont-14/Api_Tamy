<?php

require_once __DIR__ . '/../controllers/ClubController.php';
require_once __DIR__ . '/../controllers/TournamentController.php';
require_once __DIR__ . '/../controllers/CourtController.php';
require_once __DIR__ . '/../controllers/SlotController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/ReservationController.php';
require_once __DIR__ . '/../controllers/ReservationUserController.php';
require_once __DIR__ . '/../controllers/MatchController.php';
require_once __DIR__ . '/../controllers/PlayerStatsController.php';
require_once __DIR__ . '/../controllers/TournamentPlayerController.php';
require_once __DIR__ . '/../controllers/UserBadgeController.php';
require_once __DIR__ . '/../controllers/BadgeController.php';
require_once __DIR__ . '/../controllers/RoleController.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$handled = false;

// Routes Clubs
if ($uri === '/clubs' && $method === 'GET') {
    listClubs();
    $handled = true;
} elseif (preg_match('#^/clubs/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getClub($matches[1]);
    $handled = true;
} elseif ($uri === '/clubs' && $method === 'POST') {
    createClub();
    $handled = true;
} elseif (preg_match('#^/clubs/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    updateClub($matches[1]);
    $handled = true;
} elseif (preg_match('#^/clubs/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteClub($matches[1]);
    $handled = true;
}

// Routes Tournaments
elseif ($uri === '/tournaments' && $method === 'GET') {
    listTournaments();
    $handled = true;
} elseif (preg_match('#^/tournaments/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getTournament($matches[1]);
    $handled = true;
} elseif ($uri === '/tournaments' && $method === 'POST') {
    createTournament();
    $handled = true;
} elseif (preg_match('#^/tournaments/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    updateTournament($matches[1]);
    $handled = true;
} elseif (preg_match('#^/tournaments/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteTournament($matches[1]);
    $handled = true;
}

// Routes Courts
elseif ($uri === '/courts' && $method === 'GET') {
    listCourts();
    $handled = true;
} elseif (preg_match('#^/courts/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getCourt($matches[1]);
    $handled = true;
} elseif ($uri === '/courts' && $method === 'POST') {
    createCourt();
    $handled = true;
} elseif (preg_match('#^/courts/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    updateCourt($matches[1]);
    $handled = true;
} elseif (preg_match('#^/courts/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteCourt($matches[1]);
    $handled = true;
}

// Routes Slots
elseif ($uri === '/slots' && $method === 'GET') {
    listSlots();
    $handled = true;
} elseif (preg_match('#^/slots/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getSlot($matches[1]);
    $handled = true;
} elseif ($uri === '/slots' && $method === 'POST') {
    createSlot();
    $handled = true;
} elseif (preg_match('#^/slots/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    updateSlot($matches[1]);
    $handled = true;
} elseif (preg_match('#^/slots/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteSlot($matches[1]);
    $handled = true;
}

// Routes Users
elseif ($uri === '/users' && $method === 'GET') {
    listUsers();
    $handled = true;
} elseif (preg_match('#^/users/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getUser($matches[1]);
    $handled = true;
} elseif ($uri === '/users' && $method === 'POST') {
    createUser();
    $handled = true;
} elseif (preg_match('#^/users/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    updateUser($matches[1]);
    $handled = true;
} elseif (preg_match('#^/users/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteUser($matches[1]);
    $handled = true;
}

// Routes Reservations
elseif ($uri === '/reservations' && $method === 'GET') {
    listReservations();
    $handled = true;
} elseif (preg_match('#^/reservations/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getReservation($matches[1]);
    $handled = true;
} elseif ($uri === '/reservations' && $method === 'POST') {
    createReservation();
    $handled = true;
} elseif (preg_match('#^/reservations/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    updateReservation($matches[1]);
    $handled = true;
} elseif (preg_match('#^/reservations/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteReservation($matches[1]);
    $handled = true;
}

// Routes ReservationUsers
elseif ($uri === '/reservation-users' && $method === 'GET') {
    listReservationUsers();
    $handled = true;
} elseif (preg_match('#^/reservation-users/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getReservationUsers($matches[1]);
    $handled = true;
} elseif ($uri === '/reservation-users' && $method === 'POST') {
    addReservationUser();
    $handled = true;
} elseif (preg_match('#^/reservation-users/(\d+)/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteReservationUser($matches[1], $matches[2]);
    $handled = true;
}


// Routes Matches
elseif ($uri === '/matches' && $method === 'GET') {
    listMatches();
    $handled = true;
} elseif (preg_match('#^/matches/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getMatch($matches[1]);
    $handled = true;
} elseif ($uri === '/matches' && $method === 'POST') {
    createMatch();
    $handled = true;
} elseif (preg_match('#^/matches/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    updateMatch($matches[1]);
    $handled = true;
} elseif (preg_match('#^/matches/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteMatch($matches[1]);
    $handled = true;
}

// Routes PlayerStats
elseif ($uri === '/player-stats' && $method === 'GET') {
    listPlayerStats();
    $handled = true;
} elseif (preg_match('#^/player-stats/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getPlayerStats($matches[1]);
    $handled = true;
} elseif ($uri === '/player-stats' && in_array($method, ['POST', 'PUT'])) {
    createOrUpdatePlayerStats();
    $handled = true;
}

// Routes TournamentPlayers
elseif ($uri === '/tournament-players' && $method === 'GET') {
    listTournamentPlayers();
    $handled = true;
} elseif (preg_match('#^/tournament-players/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getPlayersByTournament($matches[1]);
    $handled = true;
} elseif ($uri === '/tournament-players' && $method === 'POST') {
    addPlayerToTournament();
    $handled = true;
} elseif (preg_match('#^/tournament-players/(\d+)/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    removePlayerFromTournament($matches[1], $matches[2]);
    $handled = true;
}

// Routes UserBadges
elseif ($uri === '/user-badges' && $method === 'GET') {
    listUserBadges();
    $handled = true;
} elseif (preg_match('#^/user-badges/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getBadgesByUser($matches[1]);
    $handled = true;
} elseif ($uri === '/user-badges' && $method === 'POST') {
    assignBadgeToUser();
    $handled = true;
} elseif (preg_match('#^/user-badges/(\d+)/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    removeBadgeFromUser($matches[1], $matches[2]);
    $handled = true;
}

// Routes Badges
elseif ($uri === '/badges' && $method === 'GET') {
    listBadges();
    $handled = true;
} elseif (preg_match('#^/badges/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getBadge($matches[1]);
    $handled = true;
} elseif ($uri === '/badges' && $method === 'POST') {
    createBadge();
    $handled = true;
} elseif (preg_match('#^/badges/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    updateBadge($matches[1]);
    $handled = true;
} elseif (preg_match('#^/badges/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteBadge($matches[1]);
    $handled = true;
}


// Routes Roles
elseif ($uri === '/roles' && $method === 'GET') {
    listRoles();
    $handled = true;
} elseif (preg_match('#^/roles/(\d+)$#', $uri, $matches) && $method === 'GET') {
    getRole($matches[1]);
    $handled = true;
} elseif ($uri === '/roles' && $method === 'POST') {
    createRole();
    $handled = true;
} elseif (preg_match('#^/roles/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    updateRole($matches[1]);
    $handled = true;
} elseif (preg_match('#^/roles/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    deleteRole($matches[1]);
    $handled = true;
}


// Si aucune route n’a été gérée
if (!$handled) {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}
